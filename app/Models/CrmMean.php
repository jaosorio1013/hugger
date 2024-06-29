<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrmMean extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
