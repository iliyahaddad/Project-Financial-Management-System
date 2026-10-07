@extends('layouts.app')
@section('title', 'پیش‌بینی‌ها')
@section('page_title', 'پیش‌بینی مالی پروژه')
@section('content')
<div class="space-y-4">
  <div class="bg-white rounded-lg shadow p-6">
    <h3 class="font-semibold mb-4">ثبت پیش‌بینی جدید</h3>
    @livewire('forecast.forecast-form', ['project' => $project])
  </div>
  <div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full">
      <thead class="bg-slate-800 text-white">
        <tr>
          <th class="px-4 py-3 text-center">تاریخ</th>
          <th class="px-4 py-3 text-center">مدل</th>
          <th class="px-4 py-3 text-center">EAC</th>
          <th class="px-4 py-3 text-center">سود پیش‌بینی</th>
          <th class="px-4 py-3 text-center">حاشیه سود</th>
        </tr>
      </thead>
      <tbody>
        @forelse($forecasts as $forecast)
          <tr class="border-b">
            <td class="px-4 py-3 text-center">{{ $forecast->forecast_date }}</td>
            <td class="px-4 py-3 text-center">{{ $forecast->model_type }}</td>
            <td class="px-4 py-3 text-center">{{ number_format($forecast->selected_eac ?? $forecast->eac_system ?? 0) }}</td>
            <td class="px-4 py-3 text-center">{{ number_format($forecast->forecast_profit ?? 0) }}</td>
            <td class="px-4 py-3 text-center">{{ number_format($forecast->forecast_margin ?? 0, 1) }}%</td>
          </tr>
        @empty
          <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">پیش‌بینی ثبت نشده</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
