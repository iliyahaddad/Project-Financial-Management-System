<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'contract_id' => 'nullable|exists:contracts,id',
            'invoice_number' => 'required',
            'period' => 'nullable|date',
            'issue_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'invoice_amount' => 'required|numeric|min:0',
            'approved_amount' => 'nullable|numeric|min:0',
            'collected_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'project_id.required' => 'پروژه الزامی است.',
            'project_id.exists' => 'پروژه انتخاب شده معتبر نیست.',
            'contract_id.exists' => 'قرارداد انتخاب شده معتبر نیست.',
            'invoice_number.required' => 'شماره فاکتور الزامی است.',
            'period.date' => 'دوره معتبر نیست.',
            'issue_date.date' => 'تاریخ صدور معتبر نیست.',
            'due_date.date' => 'تاریخ سررسید معتبر نیست.',
            'invoice_amount.required' => 'مبلغ فاکتور الزامی است.',
            'invoice_amount.numeric' => 'مبلغ فاکتور باید عدد باشد.',
            'invoice_amount.min' => 'مبلغ فاکتور نمی‌تواند منفی باشد.',
            'approved_amount.numeric' => 'مبلغ تایید شده باید عدد باشد.',
            'approved_amount.min' => 'مبلغ تایید شده نمی‌تواند منفی باشد.',
            'collected_amount.numeric' => 'مبلغ وصول شده باید عدد باشد.',
            'collected_amount.min' => 'مبلغ وصول شده نمی‌تواند منفی باشد.',
            'notes.string' => 'یادداشت‌ها نامعتبر است.',
        ];
    }
}
