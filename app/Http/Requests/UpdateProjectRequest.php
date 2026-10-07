<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_code' => 'required|unique:projects,project_code,' . $this->project->id,
            'project_name' => 'required',
            'client_id' => 'required|exists:clients,id',
            'project_manager_id' => 'required|exists:users,id',
            'start_date' => 'date',
            'end_date' => 'date',
            'status' => 'in:draft,active,suspended,completed,cancelled,pending_start',
            'priority' => 'in:low,medium,high,critical',
            'progress_method' => 'in:milestone,activity,manual',
            'currency' => 'string',
            'description' => 'string',
        ];
    }

    public function messages(): array
    {
        return [
            'project_code.required' => 'کد پروژه الزامی است.',
            'project_code.unique' => 'این کد پروژه قبلا ثبت شده است.',
            'project_name.required' => 'نام پروژه الزامی است.',
            'client_id.required' => 'مشتری الزامی است.',
            'client_id.exists' => 'مشتری انتخاب شده معتبر نیست.',
            'project_manager_id.required' => 'مدیر پروژه الزامی است.',
            'project_manager_id.exists' => 'مدیر پروژه انتخاب شده معتبر نیست.',
            'start_date.date' => 'تاریخ شروع معتبر نیست.',
            'end_date.date' => 'تاریخ پایان معتبر نیست.',
            'status.in' => 'وضعیت پروژه نامعتبر است.',
            'priority.in' => 'اولویت نامعتبر است.',
            'progress_method.in' => 'روش محاسبه پیشرفت نامعتبر است.',
            'currency.string' => 'واحد پولی نامعتبر است.',
            'description.string' => 'توضیحات نامعتبر است.',
        ];
    }
}
