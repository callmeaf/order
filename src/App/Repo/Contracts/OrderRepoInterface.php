<?php

namespace Callmeaf\Order\App\Repo\Contracts;

use Callmeaf\Base\App\Repo\Contracts\BaseRepoInterface;
use Callmeaf\Order\App\Models\Order;
use Callmeaf\Order\App\Http\Resources\Api\V1\OrderCollection;
use Callmeaf\Order\App\Http\Resources\Api\V1\OrderResource;

/**
 * @extends BaseRepoInterface<Order,OrderResource,OrderCollection>
 */
interface OrderRepoInterface extends BaseRepoInterface
{
    public function newCode(): string;
}
