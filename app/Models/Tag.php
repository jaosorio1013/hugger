<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mailchimp_id',
        'mailchimp_name',
    ];

    protected static function boot(): void
    {
        parent::boot();

        self::saving(function (Tag $tag) {
            $tag->mailchimp_name = config('hugger.MAILCHIMP_TAG_PREFIX') . $tag->name;
        });
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class)->withTimestamps();
    }
}
