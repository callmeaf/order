<?php

namespace Callmeaf\Order\App\Listeners\Api\V1;

use Callmeaf\Cart\App\Repo\Contracts\CartRepoInterface;
use Callmeaf\Order\App\Events\Api\V1\OrderCreated;

class EmptyUserCart
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
        /**
         * @var CartRepoInterface $cartRepo
         */
        $cartRepo = app(CartRepoInterface::class);
        $cartRepo->emptyCart(id: $event->order->user->currentCart->id);
    }

}
