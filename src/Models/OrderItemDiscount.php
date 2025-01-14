<?php

namespace Callmeaf\Order\Models;

use Callmeaf\Base\Contracts\HasEnum;
use Callmeaf\Base\Traits\HasDate;
use Callmeaf\Base\Traits\HasStatus;
use Callmeaf\Base\Traits\HasType;
use Callmeaf\Order\Enums\OrderItemDiscountType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class OrderItemDiscount extends Model implements HasEnum
{
    use HasDate,HasStatus,HasType;
    protected $fillable = [
        'order_item_id',
        'voucher_id',
        'type',
        'discount_price',
        'is_fixed',
    ];

    protected $casts = [
        'type' => OrderItemDiscountType::class,
        'is_fixed' => 'boolean'
    ];

    public function order(): HasOneThrough
    {
        return $this->hasOneThrough(config('callmeaf-order.model'),config('callmeaf-order-item.model'),'id','id','order_item_id','order_id');
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(config('callmeaf-order-item.model'));
    }

    public function voucher(): BelongsTo
    {
        return $this->belongsTo(config('callmeaf-voucher.model'));
    }

    public function user(): Attribute
    {
        return Attribute::get(
            fn() => $this->order?->user,
        );
    }

    public function discountPriceText(): Attribute
    {
        return Attribute::get(
            fn() => currencyFormat(value: $this->discount_price),
        );
    }

    public static function enumsLang(): array
    {
        return __('callmeaf-order::enums');
    }

}
