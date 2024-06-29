<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrmAction extends Model
{
    protected $fillable = [
        'name',
    ];

    public CONST SCHEDULE_CAMPAIGN = 'Campaña Lanzada';
}
