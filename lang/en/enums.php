<?php

use Callmeaf\Order\Enums\OrderItemDiscountType;
use Callmeaf\Order\Enums\OrderItemStatus;
use Callmeaf\Order\Enums\OrderItemType;
use Callmeaf\Order\Enums\OrderStatus;
use Callmeaf\Order\Enums\OrderType;

return [
    OrderStatus::class => [
        OrderStatus::CONFIRMED->name => 'Confirmed',
        OrderStatus::CANCELLED->name => 'Cancelled',
        OrderStatus::PENDING->name => 'Pending',
        OrderStatus::COMPLETED->name => 'Completed',
    ],
    OrderType::class => [
        OrderType::ONLINE->name => 'Online',
        OrderType::DELIVERY->name => 'Delivery'
    ],
    OrderItemStatus::class => [
        OrderItemStatus::CONFIRMED->name => 'Confirmed',
        OrderItemStatus::CANCELLED->name => 'Cancelled',
        OrderItemStatus::PENDING->name => 'Pending',
        OrderItemStatus::PACKAGING->name => 'Packaging',
        OrderItemStatus::LEAVING_WAREHOUSE->name => 'Leaving Warehouse',
        OrderItemStatus::DELIVERING->name => 'Delivering',
        OrderItemStatus::DELIVERED->name => 'Delivered',
    ],
    OrderItemType::class => [
        OrderItemType::ONLINE->name => 'Online',
        OrderItemType::DELIVERY->name => 'Delivery',
    ],
    OrderItemDiscountType::class => [
        OrderItemDiscountType::VOUCHER->name => 'Voucher',
        OrderItemDiscountType::USER_VIP->name => 'User VIP',
    ],
];
