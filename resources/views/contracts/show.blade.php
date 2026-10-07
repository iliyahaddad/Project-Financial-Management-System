@extends('layouts.app')
@section('title', $contract->contract_number)
@section('page_title', $contract->contract_number)
@section('content')
<div class="bg-white rounded-lg shadow p-6">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div><p class="text-sm text-gray-500">شماره قرارداد</p><p class="font-semibold">{{ $contract->contract_number }}</p></div>
    <div><p class="text-sm text-gray-500">نوع قرارداد</p><p class="font-semibold">{{ $contract->contract_type }}</p></div>
    <div><p class="text-sm text-gray-500">مبلغ قرارداد</p><p class="font-semibold">{{ number_format($contract->contract_amount ?? 0) }} ریال</p></div>
    <div><p class="text-sm text-gray-500">مبلغ نهایی</p><p class="font-semibold">{{ number_format($contract->final_contract_amount ?? 0) }} ریال</p></div>
    <div><p class="text-sm text-gray-500">نفرروز قرارداد</p><p class="font-semibold">{{ number_format($contract->contract_man_days ?? 0) }}</p></div>
    <div><p class="text-sm text-gray-500">وضعیت</p><p class="font-semibold">{{ $contract->status }}</p></div>
  </div>
  @if($contract->description)
    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
      <p class="text-sm text-gray-600">{{ $contract->description }}</p>
    </div>
  @endif
</div>
@endsection
