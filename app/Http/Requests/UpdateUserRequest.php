<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'password' => 'nullable|min:8|confirmed',
            'phone' => 'nullable|string',
            'national_id' => 'nullable|string',
            'role_id' => 'nullable|exists:roles,id',
            'status' => 'nullable|in:active,inactive,suspended',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'نام الزامی است.',
            'email.required' => 'ایمیل الزامی است.',
            'email.email' => 'ایمیل نامعتبر است.',
            'email.unique' => 'این ایمیل قبلا ثبت شده است.',
            'password.min' => 'رمز عبور باید حداقل 8 کاراکتر باشد.',
            'password.confirmed' => 'تایید رمز عبور مطابقت ندارد.',
            'phone.string' => 'شماره تماس نامعتبر است.',
            'national_id.string' => 'کد ملی نامعتبر است.',
            'role_id.exists' => 'نقش انتخاب شده معتبر نیست.',
            'status.in' => 'وضعیت نامعتبر است.',
        ];
    }
}
