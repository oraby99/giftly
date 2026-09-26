<?php

namespace App\Http\Requests;

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
            'items' => ['required', 'array', 'min:1', 'max:50'],
            'items.*.type' => ['required', 'string', 'in:product,gift_box,custom_gift_box'],
            'items.*.product_id' => ['nullable', 'integer'],
            'items.*.gift_box_id' => ['nullable', 'integer'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:99'],
            'items.*.products' => ['nullable', 'array'],
            'items.*.products.*.product_id' => ['required_with:items.*.products', 'integer'],
            'items.*.products.*.quantity' => ['required_with:items.*.products', 'integer', 'min:1', 'max:99'],
            'items.*.packaging_option_id' => ['nullable', 'integer'],
            'items.*.personal_message' => ['nullable', 'string', 'max:500'],
            'items.*.occasion' => ['nullable', 'string', 'max:100'],
            'items.*.recipient_type' => ['nullable', 'string', 'max:50'],
            'customer_name' => ['nullable', 'string', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:50'],
            'customer_address' => ['nullable', 'string', 'max:500'],
            'customer_notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'السلة فارغة.',
            'items.min' => 'يجب إضافة منتج واحد على الأقل.',
            'items.*.type.in' => 'نوع العنصر غير صالح.',
            'items.*.quantity.min' => 'الكمية يجب أن تكون 1 على الأقل.',
        ];
    }
}
