<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Employee extends Model
{
    use HasFactory, Blameable, LogsActivity;

    protected $fillable = [
        'legajo',
        'name',
        'email',
        'phone',
        'department_id',
        'position',
        'document_number',
        'status',
        'created_by',
        'updated_by',
    ];

    public const STATUSES = [
        'active'   => 'Activo',
        'inactive' => 'Inactivo',
    ];

    public const STATUS_COLORS = [
        'active'   => 'success',
        'inactive' => 'danger',
    ];

    public function getStatusLabel(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function getStatusBadgeColor(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'gray';
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    public function activeAssignments(): HasMany
    {
        return $this->hasMany(Assignment::class)->whereNull('returned_at');
    }

    public function licenseAssignments(): HasMany
    {
        return $this->hasMany(LicenseAssignment::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }
}
