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
        OrderType::PERSONAL->name => 'شخصی',
        OrderType::CORPORATE->name => 'صورتحساب سازمانی',
        OrderType::INTERNAL->name => 'سفارش داخلی',
        OrderType::SUBSCRIPTION->name => 'اشتراکی',
        OrderType::GIFT->name => 'هدیه',
        OrderType::MANUAL->name => 'ثبت دستی',
        OrderType::PREORDER->name => 'پیش سفارش',
        OrderType::WHOLESALE->name => 'عمده فروشی'
    ],
];
