<?php

namespace App\Notifications;

use App\Models\MaintenanceRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MaintenanceAlertNotification extends Notification
{
    use Queueable;

    public function __construct(
        public MaintenanceRecord $record,
        public string $alertType,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $assetTag = $this->record->asset?->asset_tag ?? 'N/A';
        $assetName = $this->record->asset?->name ?? 'N/A';

        return [
            'maintenance_id' => $this->record->id,
            'asset_tag'      => $assetTag,
            'asset_name'     => $assetName,
            'type'           => $this->record->type,
            'status'         => $this->record->status,
            'started_at'     => $this->record->started_at?->format('d/m/Y'),
            'alert_type'     => $this->alertType,
            'message'        => match ($this->alertType) {
                'prolonged' => "Mantenimiento prolongado: {$assetTag} - {$assetName} ({$this->record->started_at?->diffForHumans()})",
                'completed' => "Mantenimiento completado: {$assetTag} - {$assetName}",
                default     => "Alerta de mantenimiento: {$assetTag} - {$assetName}",
            },
        ];
    }
}
