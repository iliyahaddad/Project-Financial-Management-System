<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWbsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'parent_id' => 'nullable|exists:wbs,id',
            'name' => 'required',
            'code' => 'nullable|string',
            'budget' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'weight' => 'nullable|numeric|between:0,100',
            'planned_progress' => 'nullable|numeric|between:0,100',
            'actual_progress' => 'nullable|numeric|between:0,100',
            'responsible_person_id' => 'nullable|exists:users,id',
            'status' => 'nullable|in:not_started,in_progress,completed,delayed',
        ];
    }

    public function messages(): array
    {
        return [
            'project_id.required' => 'پروژه الزامی است.',
            'project_id.exists' => 'پروژه انتخاب شده معتبر نیست.',
            'parent_id.exists' => 'والد انتخاب شده معتبر نیست.',
            'name.required' => 'نام فعالیت الزامی است.',
            'code.string' => 'کد نامعتبر است.',
            'budget.numeric' => 'بودجه باید عدد باشد.',
            'budget.min' => 'بودجه نمی‌تواند منفی باشد.',
            'start_date.date' => 'تاریخ شروع معتبر نیست.',
            'end_date.date' => 'تاریخ پایان معتبر نیست.',
            'weight.numeric' => 'ضریب باید عدد باشد.',
            'weight.between' => 'ضریب باید بین 0 تا 100 باشد.',
            'planned_progress.numeric' => 'پیشرفت برنامه ای باید عدد باشد.',
            'planned_progress.between' => 'پیشرفت برنامه ای باید بین 0 تا 100 باشد.',
            'actual_progress.numeric' => 'پیشرفت واقعی باید عدد باشد.',
            'actual_progress.between' => 'پیشرفت واقعی باید بین 0 تا 100 باشد.',
            'responsible_person_id.exists' => 'مسئول انتخاب شده معتبر نیست.',
            'status.in' => 'وضعیت نامعتبر است.',
        ];
    }
}
