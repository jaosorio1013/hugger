<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class DealDetail extends Model
{
    use SoftDeletes, HasFactory;

    use LogsActivity;

    protected $fillable = [
        'deal_id',
        'client_id',
        'product_id',
        'quantity',
        'price',
        'total',
    ];

    protected static function boot(): void
    {
        parent::boot();

        self::creating(function (DealDetail $dealDetail) {
            $dealDetail->client_id = $dealDetail->deal->client_id;
        });

        self::saving(function (DealDetail $dealDetail) {
            $dealDetail->total = $dealDetail->price * $dealDetail->quantity;
        });

        self::saved(function (DealDetail $dealDetail) {
            $dealDetail->deal()->update([
                'total' => DealDetail::where('deal_id', $dealDetail->deal_id)->sum('total'),
            ]);
        });
    }

    public function deal(): BelongsTo
    {
        return $this->belongsTo(Deal::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Detalle Venta')
            ->logFillable()
            ->logOnlyDirty();
    }
}
