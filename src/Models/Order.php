<?php

namespace Callmeaf\Order\Models;

use Callmeaf\Base\Contracts\HasEnum;
use Callmeaf\Base\Contracts\HasResponseTitles;
use Callmeaf\Base\Enums\ResponseTitle;
use Callmeaf\Base\Traits\HasDate;
use Callmeaf\Base\Traits\HasMediaMethod;
use Callmeaf\Base\Traits\HasStatus;
use Callmeaf\Base\Traits\HasType;
use Callmeaf\Base\Traits\Metaable;
use Callmeaf\Order\Enums\OrderStatus;
use Callmeaf\Order\Enums\OrderType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Order extends Model implements HasResponseTitles,HasEnum,HasMedia
{
    use HasDate,HasStatus,HasType,SoftDeletes,InteractsWithMedia,HasMediaMethod,Metaable;
    protected $fillable = [
        'user_id',
        'status',
        'type',
        'ref_code',
        'total_price',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
        'type' => OrderType::class,
    ];

    protected static function booted(): void
    {
        static::creating(function(Model $model) {
            $model->forceFill([
                'user_id' => $model->user_id ?? authId(),
                'ref_code' => $model->ref_code ?? app(config('callmeaf-order.service'))->newRefCode(),
            ]);
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('callmeaf-user.model'));
    }

    public function items(): HasMany
    {
        return $this->hasMany(config('callmeaf-order-item.model'));
    }

    public function discounts(): HasManyThrough
    {
        return $this->hasManyThrough(config('callmeaf-order-item-discount.model'),config('callmeaf-order-item.model'),'order_id','order_item_id','id','id');
    }

    public function totalPriceText(): Attribute
    {
        return Attribute::get(
            fn() => currencyFormat(value: $this->total_price),
        );
    }

    public function responseTitles(ResponseTitle|string $key,string $default = ''): string
    {
        return [
            'store' => $this->ref_code ?? $default,
            'update' => $this->ref_code ?? $default,
            'status_update' => $this->ref_code ?? $default,
            'destroy' => $this->ref_code ?? $default,
            'restore' => $this->ref_code ?? $default,
            'force_destroy' => $this->ref_code ?? $default,
        ][$key instanceof ResponseTitle ? $key->value : $key];
    }

    public static function enumsLang(): array
    {
        return __('callmeaf-order::enums');
    }

}
