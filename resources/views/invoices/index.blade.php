@extends('layouts.app')
@section('title', 'صورت‌وضعیت‌ها')
@section('page_title', 'مدیریت صورت‌وضعیت‌ها')
@section('content')
<div class="space-y-4">
  <div class="flex justify-between items-center">
    <a href="{{ route('projects.invoices.create', $project) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">ثبت صورت‌وضعیت جدید</a>
  </div>
  <div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full">
      <thead class="bg-slate-800 text-white">
        <tr>
          <th class="px-4 py-3 text-right">شماره</th>
          <th class="px-4 py-3 text-center">مبلغ</th>
          <th class="px-4 py-3 text-center">تأییدشده</th>
          <th class="px-4 py-3 text-center">وصول‌شده</th>
          <th class="px-4 py-3 text-center">باقی‌مانده</th>
          <th class="px-4 py-3 text-center">وضعیت</th>
        </tr>
      </thead>
      <tbody>
        @forelse($invoices as $invoice)
          <tr class="border-b">
            <td class="px-4 py-3">{{ $invoice->invoice_number }}</td>
            <td class="px-4 py-3 text-center">{{ number_format($invoice->invoice_amount ?? 0) }}</td>
            <td class="px-4 py-3 text-center">{{ number_format($invoice->approved_amount ?? 0) }}</td>
            <td class="px-4 py-3 text-center">{{ number_format($invoice->collected_amount ?? 0) }}</td>
            <td class="px-4 py-3 text-center">{{ number_format(($invoice->approved_amount ?? 0) - ($invoice->collected_amount ?? 0)) }}</td>
            <td class="px-4 py-3 text-center">
              <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ $invoice->status }}</span>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">صورت‌وضعیتی ثبت نشده</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
