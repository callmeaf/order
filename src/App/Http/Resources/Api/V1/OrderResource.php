<?php

namespace Callmeaf\Order\App\Http\Resources\Api\V1;

use Callmeaf\Order\App\Models\Order;
use Callmeaf\OrderItem\App\Repo\Contracts\OrderItemRepoInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Order $resource
 */
class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * @var OrderItemRepoInterface $orderItemRepo
         */
        $orderItemRepo = app(OrderItemRepoInterface::class);
        return [
            'code' => $this->code,
            'status' => $this->status,
            'status_text' => $this->statusText,
            'type' => $this->type,
            'type_text' => $this->typeText,
            'user_identifier' => $this->user_identifier,
            'total_price' => $this->total_price,
            'created_at' => $this->created_at,
            'created_at_text' => $this->createdAtText(),
            'updated_at' => $this->updated_at,
            'updated_at_text' => $this->updatedAtText(),
            'deleted_at' => $this->deleted_at,
            'deleted_at_text' => $this->deletedAtText(),
            'items' => $orderItemRepo->toResourceCollection($this->whenLoaded('items')),
        ];
    }
}
