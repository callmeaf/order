<?php

namespace Callmeaf\Order\Utilities\V1\Api\OrderItem;

use Callmeaf\Base\Utilities\V1\FormRequestValidator;

class OrderItemFormRequestValidator extends FormRequestValidator
{
    public function update(): array
    {
        return [
            'status' => false,
            'type' => false,
            'qty' => false,
        ];
    }
    public function statusUpdate(): array
    {
        return [
            'status' => true,
        ];
    }

    public function destroy(): array
    {
        return [];
    }
}
