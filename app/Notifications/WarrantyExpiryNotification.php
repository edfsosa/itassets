<?php

namespace App\Notifications;

use App\Models\Asset;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class WarrantyExpiryNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Asset $asset,
        public int $daysRemaining,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $isExpired = $this->daysRemaining <= 0;

        return [
            'asset_id'      => $this->asset->id,
            'asset_tag'     => $this->asset->asset_tag,
            'asset_name'    => $this->asset->name,
            'expiry_date'   => $this->asset->warranty_expiry_date?->format('d/m/Y'),
            'days_remaining' => $this->daysRemaining,
            'type'          => $isExpired ? 'warranty_expired' : 'warranty_expiring',
            'message'       => $isExpired
                ? "Garantía vencida: {$this->asset->asset_tag} {$this->asset->name}"
                : "Garantía por vencer ({$this->daysRemaining} días): {$this->asset->asset_tag} {$this->asset->name}",
        ];
    }
}
