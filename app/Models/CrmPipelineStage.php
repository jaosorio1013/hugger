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

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }
}
