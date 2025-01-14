<?php

namespace Callmeaf\Order\Models;

use Callmeaf\Base\Contracts\HasEnum;
use Callmeaf\Base\Contracts\HasResponseTitles;
use Callmeaf\Base\Enums\ResponseTitle;
use Callmeaf\Base\Traits\HasDate;
use Callmeaf\Base\Traits\HasStatus;
use Callmeaf\Base\Traits\HasType;
use Callmeaf\Order\Enums\OrderItemStatus;
use Callmeaf\Order\Enums\OrderItemType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItem extends Model implements HasEnum,HasResponseTitles
{
    use HasDate,HasStatus,HasType;
    protected $fillable = [
        'order_id',
        'variation_id',
        'status',
        'type',
        'price',
        'qty',
    ];

    protected $casts = [
        'status' => OrderItemStatus::class,
        'type' => OrderItemType::class,
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(config('callmeaf-order.model'));
    }

    public function variation(): BelongsTo
    {
        return $this->belongsTo(config('callmeaf-variation.model'));
    }

    public function discount(): HasOne
    {
        return $this->hasOne(config('callmeaf-order-item-discount.model'));
    }

    public function priceText(): Attribute
    {
        return Attribute::get(
            fn() => currencyFormat(value: $this->price),
        );
    }

    public function responseTitles(ResponseTitle|string $key,string $default = ''): string
    {
        return [
            'store' => $this->variation?->title ?? $default,
            'update' => $this->variation?->title ?? $default,
            'status_update' => $this->variation?->title ?? $default,
            'destroy' => $this->variation?->title ?? $default,
            'restore' => $this->variation?->title ?? $default,
            'force_destroy' => $this->variation?->title ?? $default,
        ][$key instanceof ResponseTitle ? $key->value : $key];
    }

    public static function enumsLang(): array
    {
        return __('callmeaf-order::enums');
    }

}
