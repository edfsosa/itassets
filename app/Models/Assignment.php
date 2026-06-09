<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'employee_id',
        'assigned_by',
        'assigned_at',
        'returned_at',
        'notes',
    ];

    protected $casts = [
        'assigned_at' => 'date',
        'returned_at' => 'date',
    ];

    // -------------------------------------------------------------------------
    // Cambio automático de estado del activo
    // -------------------------------------------------------------------------
    protected static function booted(): void
    {
        // Al crear una asignación → el activo pasa a "Asignado"
        static::created(function (Assignment $assignment) {
            $assignment->asset->update(['status' => 'assigned']);
        });

        // Al registrar devolución → el activo pasa a "Disponible"
        static::updated(function (Assignment $assignment) {
            if ($assignment->wasChanged('returned_at') && ! is_null($assignment->returned_at)) {
                $assignment->asset->update(['status' => 'available']);
            }
        });
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------
    public function scopeActive($query)
    {
        return $query->whereNull('returned_at');
    }

    public function scopeReturned($query)
    {
        return $query->whereNotNull('returned_at');
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------
    public function isActive(): bool
    {
        return is_null($this->returned_at);
    }

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
