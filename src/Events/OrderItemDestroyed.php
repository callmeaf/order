<?php

namespace Callmeaf\Order\Events;

use Callmeaf\Order\Models\OrderItem;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderItemDestroyed
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public OrderItem $orderItem)
    {

    }
}
