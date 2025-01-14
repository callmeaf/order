<?php

use Callmeaf\Order\Enums\OrderItemDiscountType;
use Callmeaf\Order\Enums\OrderItemStatus;
use Callmeaf\Order\Enums\OrderItemType;
use Callmeaf\Order\Enums\OrderStatus;
use Callmeaf\Order\Enums\OrderType;

return [
    OrderStatus::class => [
        OrderStatus::CONFIRMED->name => 'تایید شده',
        OrderStatus::CANCELLED->name => 'کنسل شده',
        OrderStatus::PENDING->name => 'در انتظار تایید',
        OrderStatus::COMPLETED->name => 'کامل شده',
    ],
    OrderType::class => [
        OrderType::ONLINE->name => 'آنلاین',
        OrderType::DELIVERY->name => 'نقل و انتقال'
    ],
    OrderItemStatus::class => [
        OrderItemStatus::CONFIRMED->name => 'تایید شده',
        OrderItemStatus::CANCELLED->name => 'کنسل شده',
        OrderItemStatus::PENDING->name => 'در انتظار تایید',
        OrderItemStatus::PACKAGING->name => 'در حال بسته بندی',
        OrderItemStatus::LEAVING_WAREHOUSE->name => 'خروج از انبار',
        OrderItemStatus::DELIVERING->name => 'ارسال شده',
        OrderItemStatus::DELIVERED->name => 'تحویل داده شده',
    ],
    OrderItemType::class => [
        OrderItemType::ONLINE->name => 'Online',
        OrderItemType::DELIVERY->name => 'Delivery',
    ],
    OrderItemDiscountType::class => [
        OrderItemDiscountType::VOUCHER->name => 'کد تخفیف',
        OrderItemDiscountType::USER_VIP->name => 'کاربر ویژه',
    ],
];
