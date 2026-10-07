<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'wbs_id' => 'nullable|exists:wbs,id',
            'activity_id' => 'nullable|exists:activities,id',
            'period' => 'required|date',
            'planned_progress' => 'required|numeric|between:0,100',
            'actual_progress' => 'required|numeric|between:0,100',
            'management_note' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'project_id.required' => 'پروژه الزامی است.',
            'project_id.exists' => 'پروژه انتخاب شده معتبر نیست.',
            'wbs_id.exists' => 'فعالیت انتخاب شده معتبر نیست.',
            'activity_id.exists' => 'فعالیت انتخاب شده معتبر نیست.',
            'period.required' => 'دوره الزامی است.',
            'period.date' => 'دوره معتبر نیست.',
            'planned_progress.required' => 'پیشرفت برنامه ای الزامی است.',
            'planned_progress.numeric' => 'پیشرفت برنامه ای باید عدد باشد.',
            'planned_progress.between' => 'پیشرفت برنامه ای باید بین 0 تا 100 باشد.',
            'actual_progress.required' => 'پیشرفت واقعی الزامی است.',
            'actual_progress.numeric' => 'پیشرفت واقعی باید عدد باشد.',
            'actual_progress.between' => 'پیشرفت واقعی باید بین 0 تا 100 باشد.',
            'management_note.string' => 'یادداشت مدیریت نامعتبر است.',
        ];
    }
}
