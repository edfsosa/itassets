<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_tag',
        'name',
        'asset_category_id',
        'brand',
        'model',
        'serial_number',
        'status',
        'condition',
        'photo',
        'notes',
        'purchase_date',
        'purchase_price',
        'supplier_id',
        'location_id',
        'warranty_expiry_date',
        'warranty_supplier_id',
    ];

    protected $casts = [
        'purchase_date'        => 'date',
        'warranty_expiry_date' => 'date',
        'purchase_price'       => 'decimal:2',
    ];

    public const STATUSES = [
        'stock'       => 'En stock / Almacén',
        'available'   => 'Disponible',
        'assigned'    => 'Asignado',
        'maintenance' => 'En mantenimiento',
        'retired'     => 'Dado de baja',
        'lost'        => 'Perdido / Robado',
    ];

    public const STATUS_COLORS = [
        'stock'       => 'info',
        'available'   => 'success',
        'assigned'    => 'primary',
        'maintenance' => 'warning',
        'retired'     => 'gray',
        'lost'        => 'danger',
    ];

    public const CONDITIONS = [
        'new'  => 'Nuevo',
        'good' => 'Bueno',
        'fair' => 'Regular',
        'poor' => 'Deteriorado',
    ];

    // -------------------------------------------------------------------------
    // Auto-generación del asset_tag
    // -------------------------------------------------------------------------
    protected static function booted(): void
    {
        static::creating(function (Asset $asset) {
            if (empty($asset->asset_tag)) {
                $lastNumber = static::query()
                    ->where('asset_tag', 'like', 'IT-%')
                    ->selectRaw("MAX(CAST(SUBSTRING(asset_tag, 4) AS UNSIGNED)) as max_num")
                    ->value('max_num') ?? 0;

                $asset->asset_tag = 'IT-' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    public function category(): BelongsTo
    {
        return $this->belongsTo(AssetCategory::class, 'asset_category_id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function warrantySupplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'warranty_supplier_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    public function activeAssignment()
    {
        return $this->hasOne(Assignment::class)->whereNull('returned_at')->latest();
    }

    public function maintenanceRecords(): HasMany
    {
        return $this->hasMany(MaintenanceRecord::class);
    }
}
