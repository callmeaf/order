<?php

namespace Callmeaf\Order\Http\Resources\V1\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
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
            'data' => $this->collection->map(fn($order) => toArrayResource(data: [
                'id' => fn() => $order->id,
                'user_id' => fn() => $order->user_id,
                'status' => fn() => $order->status,
                'status_text' => fn() => $order->statusText,
                'type' => fn() => $order->type,
                'type_text' => fn() => $order->typeText,
                'ref_code' => fn() => $order->ref_code,
                'total_price' => fn() => $order->total_price,
                'total_price_text' => fn() => $order->totalPriceText,
                'created_at' => fn() => $order->created_at,
                'created_at_text' => fn() => $order->createdAtText,
                'updated_at' => fn() => $order->updated_at,
                'updated_at_text' => fn() => $order->updatedAtText,
                'deleted_at' => fn() => $order->deleted_at,
                'deleted_at_text' => fn() => $order->deletedAtText,
                'user' => fn() => $order->user ? new (config('callmeaf-user.model_resource'))($order->user,only: $this->only['!user'] ?? []) : null,
                'items' => fn() => $order->items?->count() ? new (config('callmeaf-order-item.model_resource_collection'))($order->items,only: $this->only['!items'] ?? []) : null,
            ],only: $this->only)),
        ];
    }
}
