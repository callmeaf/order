<?php

use Callmeaf\Order\App\Enums\OrderStatus;
use Callmeaf\Order\App\Enums\OrderType;

return [
    OrderStatus::class => [
        OrderStatus::ACTIVE->name => 'Active',
        OrderStatus::INACTIVE->name => 'InActive',
        OrderStatus::PENDING->name => 'Pending',
    ],
    OrderType::class => [
        OrderType::PERSONAL->name => 'Personal',
        OrderType::CORPORATE->name => 'Corporate',
        OrderType::INTERNAL->name => 'Interval',
        OrderType::SUBSCRIPTION->name => 'Subscription',
        OrderType::GIFT->name => 'Gift',
        OrderType::MANUAL->name => 'Manual',
        OrderType::PREORDER->name => 'Preorder',
        OrderType::WHOLESALE->name => 'Wholesale'
    ],
];
