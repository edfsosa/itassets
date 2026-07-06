<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
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

    protected static function booted(): void
    {
        static::updated(function (Assignment $assignment) {
            if ($assignment->wasChanged('returned_at') && ! is_null($assignment->returned_at)) {
                foreach ($assignment->assets as $asset) {
                    $asset->update(['status' => 'available']);
                }
            }
        });
    }

    public function scopeActive(Builder $query): void
    {
        $query->whereNull('returned_at');
    }

    public function scopeReturned(Builder $query): void
    {
        $query->whereNotNull('returned_at');
    }

    public function isActive(): bool
    {
        return is_null($this->returned_at);
    }

    public function assets(): BelongsToMany
    {
        return $this->belongsToMany(Asset::class, 'assignment_asset')
            ->using(AssignmentAsset::class)
            ->withPivot(['charger_serial', 'ticket_number', 'assigned_at', 'notes'])
            ->withTimestamps();
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
