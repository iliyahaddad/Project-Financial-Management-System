<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'value' => 'required',
            'type' => 'required|in:string,number,boolean,json',
        ];
    }

    public function messages(): array
    {
        return [
            'value.required' => 'مقدار الزامی است.',
            'type.required' => 'نوع الزامی است.',
            'type.in' => 'نوع نامعتبر است.',
        ];
    }
}
