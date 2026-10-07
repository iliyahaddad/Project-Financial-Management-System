@extends('layouts.app')
@section('title', 'پیشرفت پروژه')
@section('page_title', 'ثبت پیشرفت')
@section('content')
<div class="space-y-4">
  <div class="bg-white rounded-lg shadow p-6">
    <h3 class="font-semibold mb-4">ثبت پیشرفت جدید</h3>
    @livewire('progress.progress-form', ['project' => $project])
  </div>
  <div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full">
      <thead class="bg-slate-800 text-white">
        <tr>
          <th class="px-4 py-3 text-center">دوره</th>
          <th class="px-4 py-3 text-center">پیشرفت برنامه‌ای</th>
          <th class="px-4 py-3 text-center">پیشرفت واقعی</th>
          <th class="px-4 py-3 text-center">انحراف</th>
        </tr>
      </thead>
      <tbody>
        @forelse($records as $record)
          <tr class="border-b">
            <td class="px-4 py-3 text-center">{{ $record->period }}</td>
            <td class="px-4 py-3 text-center">{{ number_format($record->planned_progress ?? 0, 1) }}%</td>
            <td class="px-4 py-3 text-center">{{ number_format($record->actual_progress ?? 0, 1) }}%</td>
            <td class="px-4 py-3 text-center">{{ number_format($record->progress_variance ?? 0, 1) }}%</td>
          </tr>
        @empty
          <tr><td colspan="4" class="px-4 py-8 text-center text-gray-500">پیشرفتی ثبت نشده</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
