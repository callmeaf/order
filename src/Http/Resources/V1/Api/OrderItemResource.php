<?php

namespace Callmeaf\Order\Http\Resources\V1\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function __construct($resource,protected array|int $only = [])
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return toArrayResource(data: [
            'id' => fn() => $this->id,
            'order_id' => fn() => $this->order_id,
            'variation_id' => fn() => $this->variation_id,
            'status' => fn() => $this->status,
            'status_text' => fn() => $this->statusText,
            'type' => fn() => $this->type,
            'type_text' => fn() => $this->typeText,
            'price' => fn() => $this->price,
            'price_text' => fn() => $this->priceText,
            'qty' => fn() => $this->qty,
            'created_at' => fn() => $this->created_at,
            'created_at_text' => fn() => $this->createdAtText,
            'updated_at' => fn() => $this->updated_at,
            'updated_at_text' => fn() => $this->updatedAtText,
            'order' => fn() => $this->order ? new (config('callmeaf-order.model_resource'))($this->order,only: $this->only['!order'] ?? []) : null,
            'variation' => fn() => $this->variation ? new (config('callmeaf-variation.model_resource'))($this->variation,only: $this->only['!variation'] ?? []) : null,
        ],only: $this->only);
    }
}
