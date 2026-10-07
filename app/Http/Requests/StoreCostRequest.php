<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'cost_category_id' => 'nullable|exists:cost_categories,id',
            'date' => 'required|date',
            'description' => 'required',
            'budget_amount' => 'nullable|numeric|min:0',
            'actual_amount' => 'nullable|numeric|min:0',
            'cost_center' => 'nullable|string',
            'employee_id' => 'nullable|exists:users,id',
            'document_number' => 'nullable|string',
            'notes' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'project_id.required' => 'پروژه الزامی است.',
            'project_id.exists' => 'پروژه انتخاب شده معتبر نیست.',
            'cost_category_id.exists' => 'دسته هزینه انتخاب شده معتبر نیست.',
            'date.required' => 'تاریخ الزامی است.',
            'date.date' => 'تاریخ معتبر نیست.',
            'description.required' => 'توضیحات الزامی است.',
            'budget_amount.numeric' => 'مبلغ بودجه باید عدد باشد.',
            'budget_amount.min' => 'مبلغ بودجه نمی‌تواند منفی باشد.',
            'actual_amount.numeric' => 'مبلغ واقعی باید عدد باشد.',
            'actual_amount.min' => 'مبلغ واقعی نمی‌تواند منفی باشد.',
            'cost_center.string' => 'مرکز هزینه نامعتبر است.',
            'employee_id.exists' => 'کارمند انتخاب شده معتبر نیست.',
            'document_number.string' => 'شماره سند نامعتبر است.',
            'notes.string' => 'یادداشت‌ها نامعتبر است.',
        ];
    }
}
