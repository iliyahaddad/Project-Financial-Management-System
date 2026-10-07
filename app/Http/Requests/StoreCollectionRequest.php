<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCollectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'invoice_id' => 'nullable|exists:invoices,id',
            'collection_number' => 'nullable|string',
            'collection_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,bank_transfer,check,other',
            'reference_number' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'notes' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'project_id.required' => 'پروژه الزامی است.',
            'project_id.exists' => 'پروژه انتخاب شده معتبر نیست.',
            'invoice_id.exists' => 'فاکتور انتخاب شده معتبر نیست.',
            'collection_number.string' => 'شماره وصول نامعتبر است.',
            'collection_date.required' => 'تاریخ وصول الزامی است.',
            'collection_date.date' => 'تاریخ وصول معتبر نیست.',
            'amount.required' => 'مبلغ الزامی است.',
            'amount.numeric' => 'مبلغ باید عدد باشد.',
            'amount.min' => 'مبلغ نمی‌تواند منفی باشد.',
            'payment_method.required' => 'روش پرداخت الزامی است.',
            'payment_method.in' => 'روش پرداخت نامعتبر است.',
            'reference_number.string' => 'شماره مرجع نامعتبر است.',
            'bank_name.string' => 'نام بانک نامعتبر است.',
            'notes.string' => 'یادداشت‌ها نامعتبر است.',
        ];
    }
}
