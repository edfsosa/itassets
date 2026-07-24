<?php

namespace App\Filament\Resources\Departments\Pages;

use App\Filament\Resources\Departments\DepartmentResource;
use App\Models\Department;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditDepartment extends EditRecord
{
    protected static string $resource = DepartmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->before(function (DeleteAction $action, Department $record): void {
                    if ($record->employees()->exists()) {
                        Notification::make()
                            ->danger()
                            ->title('No se puede eliminar')
                            ->body('Este departamento tiene empleados asociados. Reasigná esos empleados a otro departamento primero.')
                            ->send();

                        $action->halt();
                    }
                }),
        ];
    }
}
