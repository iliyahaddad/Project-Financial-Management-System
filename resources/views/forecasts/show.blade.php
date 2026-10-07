@extends('layouts.app')
@section('title', 'جزئیات پیش‌بینی')
@section('page_title', 'جزئیات پیش‌بینی')
@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-3xl">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div><p class="text-sm text-gray-500">تاریخ</p><p class="font-semibold">{{ $forecast->forecast_date }}</p></div>
    <div><p class="text-sm text-gray-500">مدل</p><p class="font-semibold">{{ $forecast->model_type }}</p></div>
    <div><p class="text-sm text-gray-500">EAC</p><p class="font-semibold">{{ number_format($forecast->selected_eac ?? $forecast->eac_system ?? 0) }}</p></div>
    <div><p class="text-sm text-gray-500">سود پیش‌بینی</p><p class="font-semibold">{{ number_format($forecast->forecast_profit ?? 0) }}</p></div>
    <div><p class="text-sm text-gray-500">حاشیه سود</p><p class="font-semibold">{{ number_format($forecast->forecast_margin ?? 0, 1) }}%</p></div>
  </div>
  @if($forecast->reason_for_override)
    <div class="mt-4 p-4 bg-yellow-50 rounded-lg">
      <p class="text-sm text-gray-600">دلیل تغییر دستی: {{ $forecast->reason_for_override }}</p>
    </div>
  @endif
</div>
@endsection
