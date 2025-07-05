<?php

namespace Callmeaf\Order\App\Enums;

enum OrderType: string
{
    case PERSONAL = 'personal';
    case CORPORATE = 'corporate';
    case INTERNAL = 'interval';
    case SUBSCRIPTION = 'subscription';
    case GIFT = 'gift';
    case MANUAL = 'manual';
    case PREORDER = 'preorder';
    case WHOLESALE = 'wholesale';
}
