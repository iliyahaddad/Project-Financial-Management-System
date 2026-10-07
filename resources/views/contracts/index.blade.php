@extends('layouts.app')
@section('title', 'قراردادها')
@section('page_title', 'قراردادهای پروژه')
@section('content')
<div class="space-y-4">
  <div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full">
      <thead class="bg-slate-800 text-white">
        <tr>
          <th class="px-4 py-3 text-right">شماره قرارداد</th>
          <th class="px-4 py-3 text-center">نوع</th>
          <th class="px-4 py-3 text-center">مبلغ</th>
          <th class="px-4 py-3 text-center">نفرروز</th>
          <th class="px-4 py-3 text-center">وضعیت</th>
        </tr>
      </thead>
      <tbody>
        @forelse($contracts as $contract)
          <tr class="border-b">
            <td class="px-4 py-3">{{ $contract->contract_number }}</td>
            <td class="px-4 py-3 text-center">{{ $contract->contract_type }}</td>
            <td class="px-4 py-3 text-center">{{ number_format($contract->contract_amount ?? 0) }}</td>
            <td class="px-4 py-3 text-center">{{ number_format($contract->contract_man_days ?? 0) }}</td>
            <td class="px-4 py-3 text-center">
              <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ $contract->status }}</span>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">قراردادی ثبت نشده</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
