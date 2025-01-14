<?php

namespace Callmeaf\Order\Enums;

enum OrderItemStatus: int
{
    case CONFIRMED = 1;
    case CANCELLED = 2;
    case PENDING = 3;
    case PACKAGING = 4;
    case LEAVING_WAREHOUSE = 5;
    case DELIVERING = 6;
    case DELIVERED = 7;
}
