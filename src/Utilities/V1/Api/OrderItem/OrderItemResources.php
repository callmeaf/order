<?php

namespace Callmeaf\Order\Utilities\V1\Api\OrderItem;

use Callmeaf\Base\Utilities\V1\Resources;

class OrderItemResources extends Resources
{
    public function update(): self
    {
        $this->data = [
            'relations' => [
                //
            ],
            'attributes' => [
                'id',
                'order_id',
                'variation_id',
                'qty',
                'type',
                'type_text',
                'status',
                'status_text',
                'price',
                'price_text',
                'created_at_text',
                'updated_at_text',
            ],
        ];
        return $this;
    }

    public function statusUpdate(): self
    {
        $this->data = [
            'relations' => [
                //
            ],
            'attributes' => [
                'id',
                'order_id',
                'variation_id',
                'qty',
                'type',
                'type_text',
                'status',
                'status_text',
                'price',
                'price_text',
                'created_at_text',
                'updated_at_text',
            ],
        ];
        return $this;
    }

    public function destroy(): self
    {
        $this->data = [
            'relations' => [
                //
            ],
            'attributes' => [
                'id',
            ],
        ];
        return $this;
    }
}
