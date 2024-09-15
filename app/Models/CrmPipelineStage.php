<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CrmPipelineStage extends Model
{
    protected $fillable = [
        'name',
        'position',
        'is_default',
    ];

    public const PROSPECTO = 'Prospecto';
    public const VENDIDO = 'Vendido';
    public const RECHAZADO = 'Rechazado';

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    public function getColorAttribute(): string
    {
        if ($this->name === static::RECHAZADO) {
            return '#ffbfbf';
        }

        if ($this->name === static::VENDIDO) {
            return '#dae6c9';
        }

        if ($this->name === static::PROSPECTO) {
            return '#f2f2f2';
        }

        return '#d9f2f5';
    }
}
