<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ClientAction extends Model
{
    use SoftDeletes, HasFactory;

    use LogsActivity;

    protected $fillable = [
        'user_id',
        'client_id',
        'crm_action_id',
        'crm_action_state_id',
        'notes',
    ];

    protected static function boot(): void
    {
        parent::boot();

        self::creating(function (ClientAction $clientAction) {
            if (Auth::check()) {
                $clientAction->user_id = Auth::id();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

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
        return $this->belongsTo(CrmActionState::class, 'crm_action_state_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Acción')
            ->logFillable()
            ->logOnlyDirty();
    }
}
