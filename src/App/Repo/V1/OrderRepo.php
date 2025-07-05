<?php

namespace Callmeaf\Order\App\Repo\V1;

use Callmeaf\Base\App\Enums\RandomType;
use Callmeaf\Base\App\Repo\V1\BaseRepo;
use Callmeaf\Cart\App\Models\Cart;
use Callmeaf\Cart\App\Repo\Contracts\CartRepoInterface;
use Callmeaf\Order\App\Http\Resources\Api\V1\OrderResource;
use Callmeaf\Order\App\Repo\Contracts\OrderRepoInterface;
use Callmeaf\OrderItem\App\Enums\OrderItemStatus;
use Callmeaf\OrderItem\App\Enums\OrderItemType;
use Callmeaf\User\App\Repo\Contracts\UserRepoInterface;

class OrderRepo extends BaseRepo implements OrderRepoInterface
{
    public function newCode(): string
    {
        $code = \Base::random(length: $this->config['code_length'], type: RandomType::NUMBER);
        $prefixCode = $this->config['code_prefix'];
        $orderCode = $prefixCode . $code;
        if ($this->getQuery()->where('code', $orderCode)->exists()) {
            return $this->newCode();
        }

        return $orderCode;
    }

    public function create(array $data)
    {
        /**
         * @var UserRepoInterface $userRepo
         */
        $userRepo = app(UserRepoInterface::class);
        $user = $userRepo->findBy($userRepo->getModel()->identifierKey(),$data['user_identifier']);
        /**
         * @var Cart $cart
         */
        $cart = $user->resource->currentCart;

        $variants = $cart->variants(withProduct: true);

        $orderItems = collect();
        foreach ($variants as $variant) {
            $qty = $variant->qty;
            $totalPrice = $variant->price * $qty;
            $totalCost = $variant->cost_price * $qty;
            $orderItems->push([
                'product_slug' => $variant->product_slug,
                'variant_sku' => $variant->sku,
                'status' => OrderItemStatus::PENDING->value,
                'type' => OrderItemType::PHYSICAL->value,
                'delivery_type' => $variant->product->type,
                'variant_type' => $variant->type,
                'qty' => $qty,
                'unit_price' => $variant->price,
                'total_price' => $variant->price * $qty,
                'cost_price' => $variant->cost_price,
                'total_cost' => $variant->cost_price * $qty,
                'profit' => $totalPrice - $totalCost,
            ]);
        }

        $data['code'] = $this->newCode();
        $data['total_price'] = $orderItems->sum('total_price');
        $data['total_cost'] = $orderItems->sum('total_cost');
        $data['total_profit'] = $orderItems->sum('profit');
        /**
         * @var OrderResource $order
         */
        $order = parent::create($data);
        $orderItems = $orderItems->map(function($item) use ($order) {
            $item['order_code'] = $order->code;
            return $item;
        });

        $order->resource->items()->insert($orderItems->toArray());

        return $order;
    }

}
