@extends('layouts.app')
@section('title', 'WBS')
@section('page_title', 'ساختار شکستن کار')
@section('content')
<div class="space-y-4">
  <div class="bg-white rounded-lg shadow p-6">
    <h3 class="font-semibold mb-4">ثبت WBS جدید</h3>
    @livewire('wbs.wbs-form', ['project' => $project])
  </div>
  <div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full">
      <thead class="bg-slate-800 text-white">
        <tr>
          <th class="px-4 py-3 text-right">کد</th>
          <th class="px-4 py-3 text-right">نام</th>
          <th class="px-4 py-3 text-center">بودجه</th>
          <th class="px-4 py-3 text-center">پیشرفت</th>
          <th class="px-4 py-3 text-center">وضعیت</th>
        </tr>
      </thead>
      <tbody>
        @forelse($wbss as $wbs)
          <tr class="border-b">
            <td class="px-4 py-3">{{ $wbs->code ?? '-' }}</td>
            <td class="px-4 py-3">{{ $wbs->name }}</td>
            <td class="px-4 py-3 text-center">{{ number_format($wbs->budget ?? 0) }}</td>
            <td class="px-4 py-3 text-center">{{ number_format($wbs->actual_progress ?? 0, 1) }}%</td>
            <td class="px-4 py-3 text-center">{{ $wbs->status ?? 'not_started' }}</td>
          </tr>
        @empty
          <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">WBS تعریف نشده</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
