<?php

namespace Callmeaf\Order\Utilities\V1\Api\Order;

use Callmeaf\Base\Utilities\V1\FormRequestAuthorizer;
use Callmeaf\Permission\Enums\PermissionName;

class OrderFormRequestAuthorizer extends FormRequestAuthorizer
{
    public function index(): bool
    {
        return true;
    }

    public function create(): bool
    {
        return userCan(PermissionName::ORDER_STORE);
    }

    public function store(): bool
    {
        return userCan(PermissionName::ORDER_STORE);
    }

    public function show(): bool
    {
        return userCan(PermissionName::ORDER_SHOW);
    }

    public function edit(): bool
    {
        return userCan(PermissionName::ORDER_UPDATE);
    }

    public function update(): bool
    {
        return userCan(PermissionName::ORDER_UPDATE);
    }

    public function statusUpdate(): bool
    {
        return userCan(PermissionName::ORDER_UPDATE);
    }

    public function destroy(): bool
    {
        return userCan(PermissionName::ORDER_DESTROY);
    }

    public function trashed(): bool
    {
        return userCan(PermissionName::ORDER_TRASHED);
    }

    public function restore(): bool
    {
        return userCan(PermissionName::ORDER_RESTORE);
    }

    public function forceDestroy(): bool
    {
        return userCan(PermissionName::ORDER_FORCE_DESTROY);
    }

    public function applyVoucher(): bool
    {
        $request = $this->request;
        $authUser = authUser(request: $request);
        if($authUser->isSuperAdminOrAdmin()) {
            return userCan(PermissionName::ORDER_STORE,user: $authUser);
        }
        return strval($authUser->id) === strval($request->route('order')->user_id) && userCan(PermissionName::ORDER_STORE,user: $authUser);
    }

    public function removeVoucher(): bool
    {
        $request = $this->request;
        $authUser = authUser(request: $request);
        if($authUser->isSuperAdminOrAdmin()) {
            return userCan(PermissionName::ORDER_STORE,user: $authUser);
        }
        return strval($authUser->id) === strval($request->route('order')->user_id) && userCan(PermissionName::ORDER_STORE,user: $authUser);
    }

}
