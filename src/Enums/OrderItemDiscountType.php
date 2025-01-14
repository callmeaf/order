<?php

namespace Callmeaf\Order\Enums;

enum OrderItemDiscountType: int
{
    case VOUCHER = 1;
    case USER_VIP = 2;
}
