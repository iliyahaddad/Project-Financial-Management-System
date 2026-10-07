<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreForecastRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'forecast_date' => 'required|date',
            'model_type' => 'required|in:progress_based,budget_based,manual',
            'actual_cost_to_date' => 'nullable|numeric|min:0',
            'actual_progress' => 'nullable|numeric|between:0,100',
            'budget_cost' => 'nullable|numeric|min:0',
            'manual_eac' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'project_id.required' => 'پروژه الزامی است.',
            'project_id.exists' => 'پروژه انتخاب شده معتبر نیست.',
            'forecast_date.required' => 'تاریخ پیش‌بینی الزامی است.',
            'forecast_date.date' => 'تاریخ پیش‌بینی معتبر نیست.',
            'model_type.required' => 'نوع مدل الزامی است.',
            'model_type.in' => 'نوع مدل نامعتبر است.',
            'actual_cost_to_date.numeric' => 'هزینه واقعی تا تاریخ باید عدد باشد.',
            'actual_cost_to_date.min' => 'هزینه واقعی تا تاریخ نمی‌تواند منفی باشد.',
            'actual_progress.numeric' => 'پیشرفت واقعی باید عدد باشد.',
            'actual_progress.between' => 'پیشرفت واقعی باید بین 0 تا 100 باشد.',
            'budget_cost.numeric' => 'هزینه بودجه باید عدد باشد.',
            'budget_cost.min' => 'هزینه بودجه نمی‌تواند منفی باشد.',
            'manual_eac.numeric' => 'مبلغ دستی باید عدد باشد.',
            'manual_eac.min' => 'مبلغ دستی نمی‌تواند منفی باشد.',
            'notes.string' => 'یادداشت‌ها نامعتبر است.',
        ];
    }
}
