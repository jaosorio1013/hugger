<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nnjeim\World\Models\City;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Client extends Model
{
    use SoftDeletes, HasFactory;

    use LogsActivity;

    public const TYPE_NATURAL = 1;
    public const TYPE_COMPANY = 2;
    public const TYPE_ALLIED = 3;
    public const TYPES = [
        self::TYPE_NATURAL => 'Persona Natural',
        self::TYPE_COMPANY => 'Empresa',
        self::TYPE_ALLIED => 'Aliado',
    ];

    protected $fillable = [
        'name',
        'nit',
        'phone',
        'email',
        'address',
        'mailchimp_id',
        'type',
        'user_id',
        'crm_font_id',
        'crm_mean_id',
        'crm_pipeline_stage_id',
        'location_city_id',
    ];

    protected $with = [
        'contacts',
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function (Client $client) {
            $client->crm_pipeline_stage_id = CrmPipelineStage::where('is_default', true)->value('id');
        });

        self::created(function (Client $client) {
            $client->actions()->create([
                'crm_pipeline_stage_id' => $client->crm_pipeline_stage_id,
                // 'employee_id' => $client->employee_id,
                'user_id' => auth()->check() ? auth()->id() : null
            ]);
        });

        self::updated(function (Client $client) {
            $lastLog = $client->actions()
                // ->whereNotNull('employee_id')
                ->latest()->first();

            // Here, we will check if the employee has changed, and if so - add a new log
            if ($lastLog && $client->employee_id !== $lastLog?->employee_id) {
                $client->actions()->create([
                    // 'employee_id' => $client->employee_id,
                    'notes' => is_null($client->employee_id) ? 'Employee removed' : '',
                    'user_id' => auth()->id()
                ]);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function font(): BelongsTo
    {
        return $this->belongsTo(CrmFont::class, 'crm_font_id');
    }

    public function mean(): BelongsTo
    {
        return $this->belongsTo(CrmMean::class, 'crm_mean_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'location_city_id');
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(ClientContact::class);
    }

    public function actions(): HasMany
    {
        return $this->hasMany(ClientAction::class);
    }

    public function stage(): BelongsTo
    {
        return $this->belongsTo(CrmPipelineStage::class, 'crm_pipeline_stage_id');
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withPivot('registered_on_mailchimp');
    }

    // public function mailchimp_audiences()
    // {
    //     return $this->belongsTo(MailchimpAudience::class);
    // }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Cliente')
            ->logFillable()
            ->logOnlyDirty();
    }

    public function getStatusNameAttribute(): string
    {
        return $this?->status->name ?? 'Indefinido';
    }
}
