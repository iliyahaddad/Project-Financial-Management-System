@extends('layouts.app')
@section('title', 'وصولی‌ها')
@section('page_title', 'مدیریت وصولی‌ها')
@section('content')
<div class="space-y-4">
  <div class="flex justify-between items-center">
    <a href="{{ route('projects.collections.create', $project) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">ثبت وصول جدید</a>
  </div>
  <div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full">
      <thead class="bg-slate-800 text-white">
        <tr>
          <th class="px-4 py-3 text-center">تاریخ</th>
          <th class="px-4 py-3 text-center">مبلغ</th>
          <th class="px-4 py-3 text-center">روش پرداخت</th>
          <th class="px-4 py-3 text-right">توضیحات</th>
        </tr>
      </thead>
      <tbody>
        @forelse($collections as $collection)
          <tr class="border-b">
            <td class="px-4 py-3 text-center">{{ $collection->collection_date }}</td>
            <td class="px-4 py-3 text-center">{{ number_format($collection->amount ?? 0) }}</td>
            <td class="px-4 py-3 text-center">{{ $collection->payment_method }}</td>
            <td class="px-4 py-3">{{ $collection->notes ?? '-' }}</td>
          </tr>
        @empty
          <tr><td colspan="4" class="px-4 py-8 text-center text-gray-500">وصولی ثبت نشده</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
