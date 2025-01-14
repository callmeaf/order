<?php

namespace Callmeaf\Order\Enums;

enum OrderType: int
{
    case ONLINE = 1;
    case DELIVERY = 2;
}
