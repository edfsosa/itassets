# Arquitectura de ITAssets

Este doc es un complemento narrativo al [`CLAUDE.md`](../CLAUDE.md) (que es una referencia rápida de comandos y convenciones) y al [`README.md`](../README.md) (que cubre instalación). Acá el objetivo es otro: explicar el **por qué** detrás de las decisiones de diseño, para que alguien nuevo en el proyecto entienda no solo dónde está cada cosa, sino por qué está ahí.

## El viaje de un request

```
Usuario → Ruta de Filament (/admin/...) → Filament Resource
                                              ├── Schema (form/infolist)
                                              ├── Table
                                              └── Page (List/Create/Edit/View)
                                                    │
                                                    ├── directo al Model (CRUD simple)
                                                    └── vía Service (lógica de negocio con side-effects)
                                                          │
                                                          └── DB (MySQL / SQLite en tests)
```

La mayoría de los 9 resources (`app/Filament/Resources/`) son CRUD simple: el form guarda directo al modelo. Pero cuando una operación tiene reglas de negocio no triviales — como iniciar o cerrar un mantenimiento — esa lógica vive en una capa de Services, no en el Resource. Ver la sección siguiente para el porqué.

## Por qué existe una capa de Services

`app/Services/AssignmentService.php` y `app/Services/MaintenanceService.php` existen porque atar la lógica de negocio directamente a un Filament Resource la deja prisionera de la UI: no se puede reusar desde un comando de consola, un job, o un test unitario sin levantar todo el stack de Livewire.

Ejemplo concreto: cuando se cierra un mantenimiento desde `ViewAsset` (`app/Filament/Resources/Assets/Pages/ViewAsset.php`), `MaintenanceService::close()` no solo marca el registro como completado — también decide a qué estado vuelve el activo (`available`, o lo que el usuario elija). Si esa lógica viviera en el botón de Filament, cualquier otro lugar que necesite "cerrar un mantenimiento" (un comando batch, una importación futura) tendría que duplicarla.

**Cuidado con los side-effects a nivel de modelo.** `MaintenanceRecord` (`app/Models/MaintenanceRecord.php`, método `booted()`) tiene sus propios hooks de Eloquent: crear un registro no completado pone el `Asset` en `maintenance`; editarlo a `completed` lo vuelve a `available`. Estos hooks corren **siempre**, sin importar si el registro se crea desde `MaintenanceService`, desde el CRUD normal de `MaintenanceRecordResource`, o desde un factory en un test. Es una fuente común de sorpresas si no se tiene presente — quedó cubierto explícitamente en `tests/Feature/Filament/MaintenanceRecordResourceTest.php`.

## Cómo funciona el sistema de permisos

Los 9 Filament Resources usan el trait `HasResourcePermissions` (`app/Filament/Concerns/HasResourcePermissions.php`), que traduce cada acción CRUD a un permiso Spatie con el patrón `{action}_{resource}` — por ejemplo `view_any_asset_category`, `delete_maintenance_record`. Los permisos se generan programáticamente (no hay un seeder de producción de permisos; en tests, `createRolesAndPermissions()` en `tests/Pest.php` los recrea desde cero) para los 3 roles: **Admin** (todo), **Editor** (todo excepto `delete_*` e `import_asset`), **Viewer** (solo `view_any_*`/`view_*`).

Un detalle importante para quien toque este trait a futuro: Filament no llama a los métodos `canX()` (`canDelete()`, `canCreate()`, etc.) para decidir si mostrar el botón de una acción como "Eliminar" — llama a un método distinto, `getXAuthorizationResponse()` (ej. `getDeleteAuthorizationResponse()`), que por default revisa Policies de Laravel. Como este proyecto no usa Policies, sobreescribir solo `canX()` deja las acciones de la UI sin proteger — hubo un bug real de este tipo (Editor podía borrar registros pese a no tener el permiso) corregido sobreescribiendo los métodos `getXAuthorizationResponse()` correctos. Los métodos `canX()` heredados de Filament ya delegan en ellos automáticamente, así que no hace falta duplicar la lógica.

## Flujo de notificaciones

```
routes/console.php (scheduler, dailyAt 08:00)
  → notifications:check (CheckExpirations)
      → por cada Asset/License/MaintenanceRecord vencido o próximo a vencer
          → por cada usuario Admin + Editor
              → ->notify(new XxxExpiryNotification(...))
                    → encolada (ShouldQueue) → tabla `jobs`
                        → queue:listen la procesa → canal `database` + `mail`
```

Las 3 notificaciones (`app/Notifications/`) implementan `ShouldQueue` para no bloquear el comando síncrono del scheduler con el envío de emails — con varios activos/licencias vencidos × varios usuarios Admin/Editor, eso puede ser docenas de envíos. El worker de colas corre vía `composer run dev` (`queue:listen --tries=1`, sin reintentos: un fallo va directo a `failed_jobs`).

## Por qué la moneda es configurable

`format_currency()` (`app/helpers.php`) y el modelo `Setting` (key-value store, `App\Models\Setting::get/set`) existen porque el proyecto empezó pensado para una instalación específica (Paraguay/Guaraníes) y se generalizó después para no asumir un país fijo. `base_currency`, `display_currency`, `exchange_rate` y `display_locale` son configurables desde el panel (`GeneralSettings`), con defaults neutrales (`USD`/`en_US`). Si tocás este helper, cuidado con la aritmética de punto flotante en la conversión — `round()` dos veces (a 6 decimales primero, después a 2) evita que errores de representación binaria redondeen mal montos que caen justo en `.5` centavos.

## Filosofía de testing

- **Pest**, no PHPUnit — sintaxis `it(...)`/`expect(...)`.
- `RefreshDatabase` en cada test de Feature (`tests/Pest.php`), SQLite en memoria — rápido, sin estado compartido entre tests.
- Los helpers `loginAsAdmin()`/`loginAsEditor()`/`loginAsViewer()` (`tests/Pest.php`) existen para no repetir el setup de roles/permisos en cada archivo — úsalos en vez de crear usuarios y asignar roles a mano.
- Los tests de Filament Resources no se limitan a comprobar que la página carga (`assertOk()`). También verifican que el CRUD via Livewire (`fillForm()`/`call('create')`/`assertHasNoFormErrors()`) realmente persiste datos, que las validaciones de formulario funcionan, y — esto es lo que destapó el bug de permisos mencionado arriba — que Viewer/Editor efectivamente no pueden hacer lo que no deberían (`assertForbidden()`, `assertActionHidden()`, `assertTableBulkActionHidden()`).

## Dónde mirar según lo que quieras cambiar

| Quiero... | Mirar |
|---|---|
| Agregar un campo a un resource | `app/Filament/Resources/{Resource}/Schemas/`, `Tables/` |
| Cambiar una regla de negocio de asignación/mantenimiento | `app/Services/` — no el Resource ni la Page |
| Agregar un permiso o cambiar qué puede hacer un rol | `tests/Pest.php` (`createRolesAndPermissions()`) + `app/Filament/Concerns/HasResourcePermissions.php` |
| Agregar una notificación nueva | `app/Notifications/`, y wiring en `app/Console/Commands/CheckExpirations.php` — recordá `implements ShouldQueue` |
| Tocar el formato de moneda | `app/helpers.php` (`format_currency()`) + `App\Models\Setting` |
