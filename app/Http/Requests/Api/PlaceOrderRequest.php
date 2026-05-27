<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class PlaceOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'address_id' => 'required|exists:addresses,_id',
            'payment_method' => 'required|in:razorpay,stripe,upi,cod',
            'coupon_code' => 'nullable|string|max:50',
            'delivery_date' => 'nullable|date|after_or_equal:today',
            'delivery_time_slot' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:500',
            'transaction_id' => 'nullable|string|max:255',
        ];
    }
}
