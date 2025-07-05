<?php

namespace Callmeaf\Order\App\Events\Web\V1;

use Callmeaf\Order\App\Models\Order;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderIndexed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @param Collection<Order> $orders
     * Create a new event instance.
     */
    public function __construct(Collection $orders)
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
