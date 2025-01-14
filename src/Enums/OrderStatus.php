<?php

namespace Callmeaf\Order\Enums;

enum OrderStatus: int
{
    case CONFIRMED = 1;
    case CANCELLED = 2;
    case PENDING = 3;
    case COMPLETED = 4;
}
