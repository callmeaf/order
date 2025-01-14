<?php

namespace Callmeaf\Order\Utilities\V1\Api\Order;

use Callmeaf\Base\Utilities\V1\Resources;

class OrderResources extends Resources
{
    public function index(): self
    {
        $this->data = [
            'relations' => [
                'user',
            ],
            'columns' => [
                'id',
                'user_id',
                'type',
                'status',
                'ref_code',
                'total_price',
                'created_at',
                'updated_at',
            ],
            'attributes' => [
                'id',
                'user_id',
                'type',
                'type_text',
                'status',
                'status_text',
                'ref_code',
                'total_price',
                'total_price_text',
                'created_at_text',
                'updated_at_text',
                'user',
                '!user' => [
                    'id',
                    'mobile',
                    'email',
                    'first_name',
                    'last_name',
                ],
            ],
        ];
        return $this;
    }

    public function store(): self
    {
        $this->data = [
            'relations' => [
                'user',
            ],
            'attributes' => [
                'id',
                'user_id',
                'type',
                'type_text',
                'status',
                'status_text',
                'ref_code',
                'total_price',
                'total_price_text',
                'created_at_text',
                'updated_at_text',
                'user',
                '!user' => [
                    'id',
                    'mobile',
                    'email',
                    'first_name',
                    'last_name',
                ],
            ],
        ];
        return $this;
    }

    public function show(): self
    {
        $this->data = [
            'relations' => [
                'user',
                'items',
                'media',
            ],
            'attributes' => [
                'id',
                'user_id',
                'type',
                'type_text',
                'status',
                'status_text',
                'ref_code',
                'total_price',
                'total_price_text',
                'created_at_text',
                'updated_at_text',
                'user',
                '!user' => [
                    'id',
                    'mobile',
                    'email',
                    'first_name',
                    'last_name',
                ],
                'items',
                '!items' => [
                    'id',
                    'price',
                    'qty'
                ],
                'documents',
                '!documents' => [
                    'id',
                    'url'
                ],
            ],
        ];
        return $this;
    }

    public function update(): self
    {
        $this->data = [
            'relations' => [
                'user'
            ],
            'attributes' => [
                'id',
                'user_id',
                'type',
                'type_text',
                'status',
                'status_text',
                'ref_code',
                'total_price',
                'total_price_text',
                'created_at_text',
                'updated_at_text',
                'user',
                '!user' => [
                    'id',
                    'mobile',
                    'email',
                    'first_name',
                    'last_name',
                ],
            ],
        ];
        return $this;
    }

    public function statusUpdate(): self
    {
        $this->data = [
            'relations' => [
                'user'
            ],
            'attributes' => [
                'id',
                'user_id',
                'type',
                'type_text',
                'status',
                'status_text',
                'ref_code',
                'total_price',
                'total_price_text',
                'created_at_text',
                'updated_at_text',
                'user',
                '!user' => [
                    'id',
                    'mobile',
                    'email',
                    'first_name',
                    'last_name',
                ],
            ],
        ];
        return $this;
    }

    public function destroy(): self
    {
        $this->data = [
            'relations' => [
                'user'
            ],
            'attributes' => [
                'id',
                'user_id',
                'type',
                'type_text',
                'status',
                'status_text',
                'ref_code',
                'total_price',
                'total_price_text',
                'created_at_text',
                'updated_at_text',
                'deleted_at',
                'deleted_at_text',
                'user',
                '!user' => [
                    'id',
                    'mobile',
                    'email',
                    'first_name',
                    'last_name',
                ],
            ],
        ];
        return $this;
    }

    public function restore(): self
    {
        $this->data = [
            'id_column' => 'id',
            'columns' => [
                'id',
                'user_id',
                'type',
                'status',
                'ref_code',
                'total_price',
                'created_at',
                'updated_at',
            ],
            'relations' => [
                'user'
            ],
            'attributes' => [
                'id',
                'user_id',
                'type',
                'type_text',
                'status',
                'status_text',
                'ref_code',
                'total_price',
                'total_price_text',
                'created_at_text',
                'updated_at_text',
                'user',
                '!user' => [
                    'id',
                    'mobile',
                    'email',
                    'first_name',
                    'last_name',
                ],
            ],
        ];
        return $this;
    }

    public function trashed(): self
    {
        $this->data = [
            'relations' => [
                'user',
            ],
            'columns' => [
                'id',
                'user_id',
                'type',
                'status',
                'ref_code',
                'total_price',
                'created_at',
                'updated_at',
                'deleted_at',
            ],
            'attributes' => [
                'id',
                'user_id',
                'type',
                'type_text',
                'status',
                'status_text',
                'ref_code',
                'total_price',
                'total_price_text',
                'created_at_text',
                'updated_at_text',
                'deleted_at',
                'deleted_at_text',
                'user',
                '!user' => [
                    'id',
                    'mobile',
                    'email',
                    'first_name',
                    'last_name',
                ],
            ],
        ];
        return $this;
    }

    public function forceDestroy(): self
    {
        $this->data = [
            'id_column' => 'id',
            'columns' => [
                'id',
                'ref_code',
            ],
            'relations' => [],
            'attributes' => [
                'id',
            ],
        ];
        return $this;
    }

    public function applyVoucher(): self
    {
        $this->data = [
            'relations' => [
                'user',
                'items.discount',
                'items.variation',
            ],
            'attributes' => [
                'id',
                'user_id',
                'type',
                'type_text',
                'status',
                'status_text',
                'ref_code',
                'total_price',
                'total_price_text',
                'created_at_text',
                'updated_at_text',
                'user',
                '!user' => [
                    'id',
                    'mobile',
                    'email',
                    'first_name',
                    'last_name',
                ],
                'items',
                '!items' => [
                    'id',
                    'type',
                    'type_text',
                    'status',
                    'status_text',
                    'price',
                    'price_text',
                    'qty',
                    'variation',
                    '!variation' => [
                        'id',
                        'title',
                    ],
                    'discount',
                    '!discount' => [
                        'id',
                        'type',
                        'type_text',
                        'discount_price',
                        'is_fixed'
                    ],
                ],
            ],
        ];
        return $this;
    }

    public function removeVoucher(): self
    {
        $this->data = [
            'relations' => [
                'user',
            ],
            'attributes' => [
                'id',
                'user_id',
                'type',
                'type_text',
                'status',
                'status_text',
                'ref_code',
                'total_price',
                'total_price_text',
                'created_at_text',
                'updated_at_text',
                'user',
                '!user' => [
                    'id',
                    'mobile',
                    'email',
                    'first_name',
                    'last_name',
                ],
            ],
        ];
        return $this;
    }

}
