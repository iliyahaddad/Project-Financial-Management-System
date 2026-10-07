<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateManDayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'period' => 'required|date',
            'planned_man_days' => 'required|numeric|min:0',
            'actual_man_days' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'project_id.required' => 'پروژه الزامی است.',
            'project_id.exists' => 'پروژه انتخاب شده معتبر نیست.',
            'period.required' => 'دوره الزامی است.',
            'period.date' => 'دوره معتبر نیست.',
            'planned_man_days.required' => 'روزهای کار برنامه ای الزامی است.',
            'planned_man_days.numeric' => 'روزهای کار برنامه ای باید عدد باشد.',
            'planned_man_days.min' => 'روزهای کار برنامه ای نمی‌تواند منفی باشد.',
            'actual_man_days.required' => 'روزهای کار واقعی الزامی است.',
            'actual_man_days.numeric' => 'روزهای کار واقعی باید عدد باشد.',
            'actual_man_days.min' => 'روزهای کار واقعی نمی‌تواند منفی باشد.',
            'notes.string' => 'یادداشت‌ها نامعتبر است.',
        ];
    }
}
