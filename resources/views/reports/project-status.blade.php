@extends('layouts.app')
@section('title', 'گزارش وضعیت پروژه‌ها')
@section('page_title', 'گزارش وضعیت پروژه‌ها')
@section('content')
<div class="space-y-6">
  @livewire('report.report-filter')
  <div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full">
      <thead class="bg-slate-800 text-white">
        <tr>
          <th class="px-4 py-3 text-right">پروژه</th>
          <th class="px-4 py-3 text-center">پیشرفت</th>
          <th class="px-4 py-3 text-center">زمان</th>
          <th class="px-4 py-3 text-center">نفرروز</th>
          <th class="px-4 py-3 text-center">هزینه</th>
          <th class="px-4 py-3 text-center">سود</th>
          <th class="px-4 py-3 text-center">وصول</th>
          <th class="px-4 py-3 text-center">وضعیت</th>
        </tr>
      </thead>
      <tbody>
        @foreach($projects as $project)
          <tr class="border-b">
            <td class="px-4 py-3">{{ $project->project_name }}</td>
            <td class="px-4 py-3 text-center">{{ number_format($project->actual_progress ?? 0, 1) }}%</td>
            <td class="px-4 py-3 text-center">{{ number_format($project->time_progress ?? 0, 1) }}%</td>
            <td class="px-4 py-3 text-center">{{ number_format($project->man_day_consumption ?? 0, 1) }}%</td>
            <td class="px-4 py-3 text-center">{{ number_format($project->cost_consumption ?? 0, 1) }}%</td>
            <td class="px-4 py-3 text-center">{{ number_format($project->forecast_margin ?? 0, 1) }}%</td>
            <td class="px-4 py-3 text-center">{{ number_format($project->collection_percent ?? 0, 1) }}%</td>
            <td class="px-4 py-3 text-center">
              @php
                $status = $project->status ?? 'normal';
                $color = $status === 'critical' ? 'bg-red-100 text-red-800' : ($status === 'warning' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800');
                $label = $status === 'critical' ? 'بحرانی' : ($status === 'warning' ? 'هشدار' : 'عادی');
              @endphp
              <span class="px-2 py-1 rounded-full text-xs font-medium {{ $color }}">{{ $label }}</span>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @include('reports._export')
</div>
@endsection
