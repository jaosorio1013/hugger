<?php

namespace App\Models;

use Filament\Notifications\Notification;
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
        'crm_pipeline_stage_id',
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

        self::saved(function (ClientAction $clientAction) {
            if ($clientAction->crm_pipeline_stage_id !== null) {
                $clientAction->client()->update([
                    'crm_pipeline_stage_id' => $clientAction->crm_pipeline_stage_id,
                ]);

                Notification::make()
                    ->title('Estado actualizado')
                    ->body('Se cambio el estado de: ' . $clientAction->client->name)
                    ->success()
                    ->send();
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

    public function stage(): BelongsTo
    {
        return $this->belongsTo(CrmPipelineStage::class, 'crm_pipeline_stage_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Acción')
            ->logFillable()
            ->logOnlyDirty();
    }
}
