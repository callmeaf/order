<?php

namespace Callmeaf\Order\Http\Resources\V1\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderItemCollection extends ResourceCollection
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
            'data' => $this->collection->map(fn($orderItem) => toArrayResource(data: [
                'id' => fn() => $orderItem->id,
                'order_id' => fn() => $orderItem->order_id,
                'variation_id' => fn() => $orderItem->variation_id,
                'status' => fn() => $orderItem->status,
                'status_text' => fn() => $orderItem->statusText,
                'type' => fn() => $orderItem->type,
                'type_text' => fn() => $orderItem->typeText,
                'price' => fn() => $orderItem->price,
                'price_text' => fn() => $orderItem->priceText,
                'qty' => fn() => $orderItem->qty,
                'created_at' => fn() => $orderItem->created_at,
                'created_at_text' => fn() => $orderItem->createdAtText,
                'updated_at' => fn() => $orderItem->updated_at,
                'updated_at_text' => fn() => $orderItem->updatedAtText,
                'order' => fn() => $orderItem->order ? new (config('callmeaf-order.model_resource'))($orderItem->order,only: $this->only['!order'] ?? []) : null,
                'variation' => fn() => $orderItem->variation ? new (config('callmeaf-variation.model_resource'))($orderItem->variation,only: $this->only['!variation'] ?? []) : null,
                'discount' => fn() => $orderItem->discount ? new (config('callmeaf-order-item-discount.model_resource'))($orderItem->discount,only: $this->only['!discount'] ?? []) : null,
            ],only: $this->only)),
        ];
    }
}
