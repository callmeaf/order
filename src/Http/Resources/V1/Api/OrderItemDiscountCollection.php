<?php

namespace Callmeaf\Order\Http\Resources\V1\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderItemDiscountCollection extends ResourceCollection
{
    public function __construct($resource,protected array|int $only = [])
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(fn($orderItemDiscount) => toArrayResource(data: [
                'id' => fn() => $orderItemDiscount->id,
                'order_id' => fn() => $orderItemDiscount->order_id,
                'voucher_id' => fn() => $orderItemDiscount->voucher_id,
                'type' => fn() => $orderItemDiscount->type,
                'type_text' => fn() => $orderItemDiscount->typeText,
                'discount_price' => fn() => $orderItemDiscount->discount_price,
                'discount_price_text' => fn() => $orderItemDiscount->discountPriceText,
                'is_fixed' => fn() => $orderItemDiscount->is_fixed,
                'created_at' => fn() => $orderItemDiscount->created_at,
                'created_at_text' => fn() => $orderItemDiscount->createdAtText,
                'updated_at' => fn() => $orderItemDiscount->updated_at,
                'updated_at_text' => fn() => $orderItemDiscount->updatedAtText,
                'order' => fn() => $orderItemDiscount->order ? new (config('callmeaf-order.model_resource'))($orderItemDiscount->order,only: $this->only['!order'] ?? []) : null,
                'voucher' => fn() => $orderItemDiscount->voucher ? new (config('callmeaf-voucher.model_resource'))($orderItemDiscount->voucher,only: $this->only['!voucher'] ?? []) : null,
            ],only: $this->only)),
        ];
    }
}
