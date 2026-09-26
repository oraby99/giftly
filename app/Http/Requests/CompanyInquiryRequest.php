<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_name' => ['required', 'string', 'max:255'],
            'contact_person' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'quantity' => ['required', 'integer', 'min:1', 'max:100000'],
            'budget' => ['nullable', 'numeric', 'min:0', 'max:99999999'],
            'message' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'company_name.required' => 'اسم الشركة مطلوب.',
            'contact_person.required' => 'اسم جهة الاتصال مطلوب.',
            'phone.required' => 'رقم الهاتف مطلوب.',
            'quantity.required' => 'عدد الصناديق مطلوب.',
            'quantity.min' => 'يجب أن يكون العدد 1 على الأقل.',
            'email.email' => 'البريد الإلكتروني غير صالح.',
        ];
    }
}
