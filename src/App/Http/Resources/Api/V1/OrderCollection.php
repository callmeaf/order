<?php

namespace Callmeaf\Order\App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @extends ResourceCollection<OrderResource>
 */
class OrderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, OrderResource>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
