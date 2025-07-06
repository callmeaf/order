<?php

namespace Callmeaf\Order\App\Listeners\Api\V1;

use Callmeaf\Comment\App\Notifications\Admin\V1\CommentStatusChangedNotification;
use Callmeaf\Order\App\Events\Api\V1\OrderCreated;
use Callmeaf\Order\App\Notifications\Api\V1\OrderCreatedNotification;

class NotifyOrderCreated
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        $order = $event->order;
        $order->user->notify(new OrderCreatedNotification(order: $order));
    }
}
