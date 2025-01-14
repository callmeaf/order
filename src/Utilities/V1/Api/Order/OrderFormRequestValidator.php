<?php

namespace Callmeaf\Order\Utilities\V1\Api\Order;

use Callmeaf\Base\Utilities\V1\FormRequestValidator;

class OrderFormRequestValidator extends FormRequestValidator
{
    public function index(): array
    {
        return [
            'ref_code' => false,
        ];
    }

    public function store(): array
    {
        $user = authUser(request: $this->request);
        if(is_null($user)) {
            // TODO: GUEST RULES
            return [
                //
            ];
        }

        $userIsSuperAdminOrAdmin = authUser(request: $this->request)->isSuperAdminOrAdmin();
        if($userIsSuperAdminOrAdmin) {
            return [
                'voucher_code' => false,
                'user_id' => true,
                'variations' => true,
                'variations.*.id' => true,
                'variations.*.qty' => false,
            ];
        }

        return [
            //
        ];
    }

    public function show(): array
    {
        return [];
    }

    public function update(): array
    {
        return [
            'voucher_code' => false,
            'variations_ids' => true,
            'variations_ids.*' => true,
        ];
    }
    public function statusUpdate(): array
    {
        return [
            'status' => true,
        ];
    }

    public function destroy(): array
    {
        return [];
    }

    public function restore(): array
    {
        return [];
    }

    public function trashed(): array
    {
        return [
            'ref_code' => false,
        ];
    }

    public function forceDestroy(): array
    {
        return [];
    }

    public function applyVoucher(): array
    {
        return [
            'voucher_code' => true,
        ];
    }

    public function removeVoucher(): array
    {
        return [
            'voucher_code' => true,
        ];
    }

}
