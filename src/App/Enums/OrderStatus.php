<?php

namespace Callmeaf\Order\App\Enums;


use Callmeaf\Base\App\Enums\BaseStatus;

enum OrderStatus: string
{
    case ACTIVE = BaseStatus::ACTIVE->value;
    case INACTIVE = BaseStatus::INACTIVE->value;
    case PENDING = BaseStatus::PENDING->value;
}
