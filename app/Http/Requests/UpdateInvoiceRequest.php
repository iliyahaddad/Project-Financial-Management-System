<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id' => ['required', 'exists:projects,id'],
            'invoice_number' => ['required', 'string', 'max:100'],
            'amount' => ['required', 'numeric', 'min:0'],
            'currency' => ['nullable', 'string', 'max:10'],
            'issued_at' => ['required', 'date'],
            'due_at' => ['nullable', 'date'],
            'description' => ['nullable', 'string', 'max:2000'],
            'status' => ['nullable', 'string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'project_id.required' => 'پروژه الزامی است.',
            'project_id.exists' => 'پروژه انتخاب شده معتبر نیست.',
            'invoice_number.required' => 'شماره فاکتور الزامی است.',
            'invoice_number.max' => 'شماره فاکتور نمی‌تواند بیشتر از 100 کاراکتر باشد.',
            'amount.required' => 'مبلغ الزامی است.',
            'amount.numeric' => 'مبلغ باید عدد باشد.',
            'amount.min' => 'مبلغ نمی‌تواند منفی باشد.',
            'issued_at.required' => 'تاریخ صدور الزامی است.',
            'issued_at.date' => 'تاریخ صدور معتبر نیست.',
        ];
    }
}
