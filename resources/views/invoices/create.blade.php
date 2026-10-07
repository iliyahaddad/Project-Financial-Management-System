@extends('layouts.app')
@section('title', 'صورت‌وضعیت جدید')
@section('page_title', 'ثبت صورت‌وضعیت جدید')
@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
  <form method="POST" action="{{ route('projects.invoices.store', $project) }}" class="space-y-4">
    @csrf
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">شماره صورت‌وضعیت</label>
      <input type="text" name="invoice_number" value="{{ old('invoice_number') }}" class="w-full border rounded-lg px-3 py-2" required>
      @error('invoice_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">دوره</label>
        <input type="text" name="period" value="{{ old('period') }}" class="w-full border rounded-lg px-3 py-2" placeholder="1404/01">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">مبلغ</label>
        <input type="number" name="invoice_amount" value="{{ old('invoice_amount') }}" class="w-full border rounded-lg px-3 py-2" step="0.01" required>
      </div>
    </div>
    <div class="flex justify-end gap-2">
      <a href="{{ route('projects.invoices.index', $project) }}" class="px-4 py-2 border rounded-lg hover:bg-gray-50">انصراف</a>
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">ثبت</button>
    </div>
  </form>
</div>
@endsection
