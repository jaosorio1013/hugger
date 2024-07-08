<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ClientAction extends Model
{
    use SoftDeletes, HasFactory;

    use LogsActivity;

    protected $fillable = [
        'client_id',
        'crm_action_id',
        'crm_state_id',
        'notes',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function action(): BelongsTo
    {
        return $this->belongsTo(CrmAction::class, 'crm_action_id');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(CrmState::class, 'crm_state_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Acción')
            ->logFillable()
            ->logOnlyDirty();
    }
}
