<?php

namespace Callmeaf\Order\App\Listeners\Api\V1;

use Callmeaf\Order\App\Events\Api\V1\OrderCreated;
use Callmeaf\Variant\App\Repo\Contracts\VariantRepoInterface;

class DecreaseVariantStock
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
         * @var VariantRepoInterface $variantRepo
         */
        $variantRepo = app(VariantRepoInterface::class);
        foreach ($event->order->variants() as $variant) {
            $variantRepo->freshQuery();
            $variantRepo->decreaseStock(id: $variant->getKey(),qty: $variant->qty);
        }
    }

}
