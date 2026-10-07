@extends('layouts.app')
@section('title', 'ثبت وصول')
@section('page_title', 'ثبت وصول جدید')
@section('content')
<form method="POST" action="{{ route('projects.collections.store', $project) }}" class="bg-white rounded-lg shadow p-6 space-y-4 max-w-xl">
  @csrf
  <div><label class="block text-sm mb-1">تاریخ</label><input type="date" name="collection_date" class="w-full border rounded-lg px-3 py-2" required></div>
  <div><label class="block text-sm mb-1">مبلغ</label><input type="number" step="0.01" name="amount" class="w-full border rounded-lg px-3 py-2" required></div>
  <div><label class="block text-sm mb-1">صورت‌وضعیت</label>
    <select name="invoice_id" class="w-full border rounded-lg px-3 py-2">
      <option value="">—</option>
      @foreach($project->invoices as $inv)<option value="{{ $inv->id }}">{{ $inv->invoice_number }}</option>@endforeach
    </select></div>
  <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">ثبت</button>
</form>
@endsection
