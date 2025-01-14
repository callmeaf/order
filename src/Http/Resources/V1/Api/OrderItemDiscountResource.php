<?php

namespace Callmeaf\Order\Http\Resources\V1\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemDiscountResource extends JsonResource
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
            'voucher_id' => fn() => $this->voucher_id,
            'type' => fn() => $this->type,
            'type_text' => fn() => $this->typeText,
            'discount_price' => fn() => $this->discount_price,
            'discount_price_text' => fn() => $this->discountPriceText,
            'is_fixed' => fn() => $this->is_fixed,
            'created_at' => fn() => $this->created_at,
            'created_at_text' => fn() => $this->createdAtText,
            'updated_at' => fn() => $this->updated_at,
            'updated_at_text' => fn() => $this->updatedAtText,
            'order' => fn() => $this->order ? new (config('callmeaf-order.model_resource'))($this->order,only: $this->only['!order'] ?? []) : null,
            'voucher' => fn() => $this->voucher ? new (config('callmeaf-voucher.model_resource'))($this->voucher,only: $this->only['!voucher'] ?? []) : null,
        ],only: $this->only);
    }
}
