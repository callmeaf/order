<?php

namespace Callmeaf\Order\Utilities\V1\Api\OrderItem;

use Callmeaf\Base\Utilities\V1\FormRequestAuthorizer;
use Callmeaf\Permission\Enums\PermissionName;

class OrderItemFormRequestAuthorizer extends FormRequestAuthorizer
{
    public function update(): bool
    {
        return userCan(PermissionName::ORDER_UPDATE);
    }

    public function statusUpdate(): bool
    {
        return userCan(PermissionName::ORDER_UPDATE);
    }

    public function destroy(): bool
    {
        return userCan(PermissionName::ORDER_DESTROY);
    }
}
