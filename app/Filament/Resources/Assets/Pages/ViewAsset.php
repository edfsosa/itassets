<?php

namespace App\Filament\Resources\Assets\Pages;

use App\Filament\Resources\Assets\AssetResource;
use App\Models\Assignment;
use App\Models\Employee;
use App\Models\MaintenanceRecord;
use App\Models\Supplier;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewAsset extends ViewRecord
{
    protected static string $resource = AssetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // ── Asignar activo ────────────────────────────────────────────────
            Action::make('assign')
                ->label('Asignar activo')
                ->icon('heroicon-o-user-plus')
                ->color('success')
                ->visible(fn () => ! in_array($this->record->status, ['assigned', 'maintenance', 'retired', 'lost']))
                ->form([
                    Select::make('employee_id')
                        ->label('Empleado')
                        ->required()
                        ->options(
                            Employee::where('status', 'active')
                                ->orderBy('name')
                                ->pluck('name', 'id')
                        )
                        ->searchable(),

                    DatePicker::make('assigned_at')
                        ->label('Fecha de asignación')
                        ->required()
                        ->default(now())
                        ->displayFormat('d/m/Y'),

                    Textarea::make('notes')
                        ->label('Notas')
                        ->rows(2),
                ])
                ->action(function (array $data): void {
                    Assignment::create([
                        'asset_id'    => $this->record->id,
                        'employee_id' => $data['employee_id'],
                        'assigned_by' => auth()->user()?->name,
                        'assigned_at' => $data['assigned_at'],
                        'notes'       => $data['notes'] ?? null,
                    ]);

                    $this->refreshFormData(['status']);

                    Notification::make()
                        ->title('Activo asignado correctamente')
                        ->success()
                        ->send();
                }),

            // ── Registrar devolución ──────────────────────────────────────────
            Action::make('return')
                ->label('Registrar devolución')
                ->icon('heroicon-o-arrow-uturn-left')
                ->color('warning')
                ->visible(fn () => $this->record->status === 'assigned')
                ->form([
                    DatePicker::make('returned_at')
                        ->label('Fecha de devolución')
                        ->required()
                        ->default(now())
                        ->displayFormat('d/m/Y'),

                    Textarea::make('notes')
                        ->label('Notas de devolución')
                        ->rows(2),
                ])
                ->action(function (array $data): void {
                    $active = $this->record->activeAssignment;

                    if ($active) {
                        $notes = $active->notes;
                        if (! empty($data['notes'])) {
                            $notes = $notes
                                ? $notes . "\n[Devolución] " . $data['notes']
                                : '[Devolución] ' . $data['notes'];
                        }

                        $active->update([
                            'returned_at' => $data['returned_at'],
                            'notes'       => $notes,
                        ]);
                    }

                    $this->refreshFormData(['status']);

                    Notification::make()
                        ->title('Devolución registrada correctamente')
                        ->success()
                        ->send();
                }),

            // ── Enviar a mantenimiento ────────────────────────────────────────
            Action::make('sendToMaintenance')
                ->label('Enviar a mantenimiento')
                ->icon('heroicon-o-wrench-screwdriver')
                ->color('warning')
                ->visible(fn () => ! in_array($this->record->status, ['maintenance', 'retired', 'lost']))
                ->form([
                    Select::make('type')
                        ->label('Tipo de mantenimiento')
                        ->required()
                        ->options(MaintenanceRecord::TYPES),

                    Textarea::make('description')
                        ->label('Descripción del problema / motivo')
                        ->required()
                        ->rows(3),

                    TextInput::make('technician')
                        ->label('Técnico responsable')
                        ->maxLength(150),

                    Select::make('supplier_id')
                        ->label('Proveedor de servicio')
                        ->options(Supplier::pluck('name', 'id'))
                        ->searchable(),

                    DatePicker::make('started_at')
                        ->label('Fecha de inicio')
                        ->required()
                        ->default(now())
                        ->displayFormat('d/m/Y'),
                ])
                ->action(function (array $data): void {
                    MaintenanceRecord::create([
                        'asset_id'    => $this->record->id,
                        'type'        => $data['type'],
                        'status'      => 'in_progress',
                        'description' => $data['description'],
                        'technician'  => $data['technician'] ?? null,
                        'supplier_id' => $data['supplier_id'] ?? null,
                        'started_at'  => $data['started_at'],
                    ]);

                    $this->refreshFormData(['status']);

                    Notification::make()
                        ->title('Activo enviado a mantenimiento')
                        ->success()
                        ->send();
                }),

            // ── Cerrar mantenimiento ──────────────────────────────────────────
            Action::make('closeMaintenance')
                ->label('Cerrar mantenimiento')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn () => $this->record->status === 'maintenance')
                ->form([
                    Select::make('new_asset_status')
                        ->label('Nuevo estado del activo')
                        ->required()
                        ->options([
                            'available' => 'Disponible',
                            'retired'   => 'Dado de baja',
                            'lost'      => 'Perdido / Robado',
                        ])
                        ->default('available'),

                    DatePicker::make('completed_at')
                        ->label('Fecha de término')
                        ->required()
                        ->default(now())
                        ->displayFormat('d/m/Y'),

                    Textarea::make('resolution')
                        ->label('Resolución / Diagnóstico final')
                        ->rows(3),
                ])
                ->action(function (array $data): void {
                    // Cerrar el registro de mantenimiento activo más reciente
                    $active = $this->record->maintenanceRecords()
                        ->where('status', '!=', 'completed')
                        ->latest('started_at')
                        ->first();

                    if ($active) {
                        $active->update([
                            'status'       => 'completed',
                            'completed_at' => $data['completed_at'],
                            'resolution'   => $data['resolution'] ?? null,
                        ]);
                    }

                    // Actualizar el estado del activo según la elección del analista
                    $this->record->update(['status' => $data['new_asset_status']]);

                    $this->refreshFormData(['status']);

                    Notification::make()
                        ->title('Mantenimiento cerrado correctamente')
                        ->success()
                        ->send();
                }),

            EditAction::make()
                ->label('Editar'),
        ];
    }
}
