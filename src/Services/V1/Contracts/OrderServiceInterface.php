<?php

namespace Callmeaf\Order\Services\V1\Contracts;

use Callmeaf\Base\Services\V1\Contracts\BaseServiceInterface;
use Callmeaf\Cart\Enums\CartType;
use Callmeaf\User\Models\User;

interface OrderServiceInterface extends BaseServiceInterface
{
    public function createOrder(array $data = [],?User $user = null,?array $events = []): self;
    public function createOrderFromVariationsIds(array $variationsData,?User $user = null,?array $events = []): self;
    public function createOrderFromUserCart(?User $user = null,CartType $cartType = CartType::CURRENT): self;
    public function createOrderFromGuestSession(): self;
    public function newRefCode(): ?string;
    public function applyVoucher(string $voucherCode): self;
    public function removeVoucher(string $voucherCode): self;
}
