# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

ITAssets — a Laravel 13 + Filament 5 admin panel for managing an organization's IT asset lifecycle (acquisition, assignment, maintenance, decommission). Livewire 4 + Tailwind CSS 4 + Vite. PHP 8.3+, MySQL in dev, SQLite in-memory in tests.

## Commands

| Action | Command | Notes |
|--------|---------|-------|
| Dev server | `composer run dev` | Starts `php artisan serve`, `php artisan queue:listen --tries=1`, and `npm run dev` concurrently |
| Run tests | `composer run test` | Runs `config:clear` first, then `php artisan test` |
| Single test | `php artisan test --filter=TestName` | |
| Check expirations | `php artisan notifications:check` | Manually runs the scheduled warranty/license/maintenance check |
| Seed DB | `php artisan migrate --seed` | Creates admin user via env vars: `ADMIN_NAME`, `ADMIN_EMAIL`, `ADMIN_PASSWORD` |
| Frontend build | `npm run build` / `npm run dev` | Vite |

## Testing

- **Pest**, not PHPUnit syntax. Feature tests use `RefreshDatabase` (`tests/Pest.php:17`).
- Helpers in `tests/Pest.php`: `loginAsAdmin()`, `loginAsEditor()`, `loginAsViewer()`, `makeAdminUser()`, etc. They call `createRolesAndPermissions()` which builds roles/permissions programmatically — no DB seed needed for tests.
- `UserFactory` has states: `admin()`, `editor()`, `viewer()` (assign roles after `create()`).
- Tests run with SQLite `:memory:`, queue=sync, cache=array, session=array.

## Architecture

- **Single-panel Filament app**: `app/Providers/Filament/AdminPanelProvider.php`.
- **Filament resources** live under `app/Filament/Resources/{Resource}/` with nested `Tables/`, `Schemas/`, `Pages/`, `RelationManagers/` subdirectories. Resources: AssetCategories, Assets, Assignments, Employees, Licenses, Locations, MaintenanceRecords, Suppliers, Users.
- **Permissions**: Spatie `laravel-permission`. Resources use a `HasResourcePermissions` trait checking `{action}_{resource}` permissions, e.g. `view_any_{resource}`, `view_{resource}`, `create_{resource}`, `update_{resource}`, `delete_{resource}`, plus custom `import_asset` / `export_report`. Three roles: **Admin** (full CRUD), **Editor** (CRUD except delete + import assets), **Viewer** (read-only).
- **Audit**: Spatie `laravel-activitylog`, wired via `CausesActivity` (on `User`) + `LogsActivity` (on models) traits.
- **Queue**: `database` driver (sync in tests); worker runs via `composer run dev`.
- **Cache/Session**: `database` driver in dev, `array` in tests.
- **Scheduler** (`routes/console.php`): `notifications:check` runs daily at 08:00, dispatching `WarrantyExpiryNotification`, `LicenseExpiryNotification`, `MaintenanceAlertNotification` to Admin + Editor roles.
- **Services**: `AssignmentService`, `MaintenanceService` hold business logic for assignment/maintenance operations — keep this logic out of Filament resource/page classes.
- **Currency**: `format_currency()` helper in `app/helpers.php` (autoloaded via composer `files`) formats amounts using PHP's `NumberFormatter` (ext-intl). Amounts are stored in the installation's `base_currency` `Setting`; `display_currency` + `exchange_rate` are optional and only apply a conversion when a secondary reporting currency differs from `base_currency`. `display_locale` controls symbol/number formatting. All configurable via the Filament `GeneralSettings` page ("Regional" section).
- **Setting model**: key-value store — `App\Models\Setting::get($key, $default)` / `::set($key, $value)`.
- **PDF**: Assignment PDFs via DomPDF at `GET /assignments/{assignment}/pdf`.
- **Import/Export**: Laravel Excel — `AssetImport`, `AssetsExport`, `AssignmentsExport`, `AssetTemplateExport`.

## Conventions

- 4-space indent, LF line endings (`.editorconfig`).
- Vite entry points: `resources/css/app.css` + `resources/js/app.js`. Tailwind CSS 4 via `@tailwindcss/vite`.

## CI/CD

- `.github/workflows/tests.yml`: on push/PR to `main`, installs PHP 8.3 + Node 22 deps, builds assets, runs `composer run test`.
- `.github/workflows/deploy.yml`: on push to `main`, deploys via a reusable workflow (`nextup-py/deploy-actions`) — runs tests and migrations, then deploys over SSH. Requires `ITASSETS_*` secrets.
