<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientTag extends Model
{
    public $timestamps = false;

    protected $table = 'client_tag';

    protected $fillable = [
        'client_id',
        'tag_id',
        'registered_on_mailchimp',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }
}
