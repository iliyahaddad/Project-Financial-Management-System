<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContractRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'contract_number' => 'required',
            'contract_type' => 'required|in:EPC,EPCM,PMC,BOOT,BOT,other',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'original_contract_amount' => 'required|numeric|min:0',
            'change_order_amount' => 'nullable|numeric|min:0',
            'total_contract_amount' => 'required|numeric|min:0',
            'contract_man_days' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'project_id.required' => 'پروژه الزامی است.',
            'project_id.exists' => 'پروژه انتخاب شده معتبر نیست.',
            'contract_number.required' => 'شماره قرارداد الزامی است.',
            'contract_type.required' => 'نوع قرارداد الزامی است.',
            'contract_type.in' => 'نوع قرارداد نامعتبر است.',
            'start_date.required' => 'تاریخ شروع قرارداد الزامی است.',
            'start_date.date' => 'تاریخ شروع معتبر نیست.',
            'end_date.required' => 'تاریخ پایان قرارداد الزامی است.',
            'end_date.date' => 'تاریخ پایان معتبر نیست.',
            'original_contract_amount.required' => 'مبلغ اولیه قرارداد الزامی است.',
            'original_contract_amount.numeric' => 'مبلغ اولیه قرارداد باید عدد باشد.',
            'original_contract_amount.min' => 'مبلغ اولیه قرارداد نمی‌تواند منفی باشد.',
            'change_order_amount.numeric' => 'مبلغ دستور تغییر باید عدد باشد.',
            'change_order_amount.min' => 'مبلغ دستور تغییر نمی‌تواند منفی باشد.',
            'total_contract_amount.required' => 'مبلغ کل قرارداد الزامی است.',
            'total_contract_amount.numeric' => 'مبلغ کل قرارداد باید عدد باشد.',
            'total_contract_amount.min' => 'مبلغ کل قرارداد نمی‌تواند منفی باشد.',
            'contract_man_days.required' => 'روزهای کار قرارداد الزامی است.',
            'contract_man_days.integer' => 'روزهای کار قرارداد باید عدد صحیح باشد.',
            'contract_man_days.min' => 'روزهای کار قرارداد نمی‌تواند منفی باشد.',
            'description.string' => 'توضیحات نامعتبر است.',
        ];
    }
}
