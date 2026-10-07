@extends('layouts.app')
@section('title', 'همه هزینه‌ها')
@section('page_title', 'مدیریت هزینه‌ها')
@section('content')
<div class="space-y-4">
  <div class="flex justify-between items-center">
    <a href="{{ route('costs.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">ثبت هزینه جدید</a>
  </div>
  <div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full">
      <thead class="bg-slate-800 text-white">
        <tr>
          <th class="px-4 py-3 text-right">پروژه</th>
          <th class="px-4 py-3 text-right">تاریخ</th>
          <th class="px-4 py-3 text-right">نوع</th>
          <th class="px-4 py-3 text-right">توضیحات</th>
          <th class="px-4 py-3 text-center">بودجه</th>
          <th class="px-4 py-3 text-center">واقعی</th>
          <th class="px-4 py-3 text-center">انحراف</th>
        </tr>
      </thead>
      <tbody>
        @forelse($costs as $cost)
          <tr class="border-b hover:bg-gray-50">
            <td class="px-4 py-3">{{ $cost->project->project_name ?? '-' }}</td>
            <td class="px-4 py-3">{{ $cost->date }}</td>
            <td class="px-4 py-3">{{ $cost->category->display_name ?? '-' }}</td>
            <td class="px-4 py-3">{{ $cost->description }}</td>
            <td class="px-4 py-3 text-center">{{ number_format($cost->budget_amount ?? 0) }}</td>
            <td class="px-4 py-3 text-center">{{ number_format($cost->actual_amount ?? 0) }}</td>
            <td class="px-4 py-3 text-center">{{ number_format(($cost->actual_amount ?? 0) - ($cost->budget_amount ?? 0)) }}</td>
          </tr>
        @empty
          <tr><td colspan="7" class="px-4 py-8 text-center text-gray-500">هزینه‌ای یافت نشد</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="mt-4">{{ $costs->links() }}</div>
</div>
@endsection
