<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'legajo',
        'name',
        'email',
        'phone',
        'department',
        'position',
        'document_number',
        'status',
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

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    public function activeAssignments(): HasMany
    {
        return $this->hasMany(Assignment::class)->whereNull('returned_at');
    }
}
