<?php

namespace Callmeaf\Order\Http\Requests\V1\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return app(config('callmeaf-order.form_request_authorizers.order'))->store();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return validationManager(rules: [
            'voucher_code' => ['string',Rule::exists(config('callmeaf-voucher.model'),'code')],
            'user_id' => [Rule::exists(config('callmeaf-user.model'),'id')],
            'variations' => ['array'],
            'variations.*.id' => [Rule::exists(config('callmeaf-variation.model'),'id')],
            'variations.*.qty' => ['integer']
        ],filters: app(config("callmeaf-order.validations.order"))->store());
    }

}
