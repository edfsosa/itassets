<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'type',
        'status',
        'description',
        'technician',
        'supplier_id',
        'cost',
        'started_at',
        'completed_at',
        'resolution',
        'notes',
    ];

    protected $casts = [
        'started_at'   => 'date',
        'completed_at' => 'date',
        'cost'         => 'decimal:2',
    ];

    public const TYPES = [
        'repair'      => 'Reparación',
        'preventive'  => 'Mantenimiento preventivo',
        'warranty'    => 'Garantía',
        'upgrade'     => 'Actualización / Upgrade',
        'other'       => 'Otro',
    ];

    public const STATUSES = [
        'pending'     => 'Pendiente',
        'in_progress' => 'En proceso',
        'completed'   => 'Completado',
    ];

    public const STATUS_COLORS = [
        'pending'     => 'warning',
        'in_progress' => 'info',
        'completed'   => 'success',
    ];

    // -------------------------------------------------------------------------
    // Al crear un registro de mantenimiento → activo pasa a "En mantenimiento"
    // -------------------------------------------------------------------------
    protected static function booted(): void
    {
        static::created(function (MaintenanceRecord $record) {
            $record->asset->update(['status' => 'maintenance']);
        });
    }

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}
