<?php

namespace App\Filament\Resources\Employees\Pages;

use App\Filament\Resources\Employees\EmployeeResource;
use App\Models\Employee;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditEmployee extends EditRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->before(function (DeleteAction $action, Employee $record): void {
                    if ($record->assignments()->exists()) {
                        Notification::make()
                            ->danger()
                            ->title('No se puede eliminar')
                            ->body('Este empleado tiene asignaciones de activos asociadas. Reasigná o eliminá esas asignaciones primero.')
                            ->send();

                        $action->halt();
                    }
                }),
        ];
    }
}
