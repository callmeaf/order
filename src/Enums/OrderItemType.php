<?php

namespace Callmeaf\Order\Enums;

enum OrderItemType: int
{
    case ONLINE = 1;
    case DELIVERY = 2;
}
