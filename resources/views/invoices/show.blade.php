@extends('layouts.app')
@section('title', 'صورت‌وضعیت')
@section('page_title', 'صورت‌وضعیت ' . $invoice->invoice_number)
@section('content')
<div class="bg-white rounded-lg shadow p-6 space-y-2">
  <p>شماره: {{ $invoice->invoice_number }}</p>
  <p>مبلغ: {{ format_currency($invoice->invoice_amount) }}</p>
  <p>مبلغ تایید شده: {{ format_currency($invoice->approved_amount) }}</p>
  <p>وصول شده: {{ format_currency($invoice->collected_amount) }}</p>
  <p>وضعیت: {{ $invoice->status }}</p>
  @if($invoice->status !== 'approved')
  <form method="POST" action="{{ route('projects.invoices.approve', [$project, $invoice]) }}">
    @csrf
    <button class="px-4 py-2 bg-green-600 text-white rounded-lg">تایید</button>
  </form>
  @endif
  <a href="{{ route('projects.invoices.index', $project) }}" class="text-blue-600">بازگشت</a>
</div>
@endsection
