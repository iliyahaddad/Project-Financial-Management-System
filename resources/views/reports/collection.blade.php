@extends('layouts.app')
@section('title', 'گزارش وصول')
@section('page_title', 'گزارش وصول')
@section('content')
@livewire('report.report-filter')
<div class="bg-white rounded-lg shadow overflow-hidden mt-4">
  <table class="min-w-full">
    <thead class="bg-slate-800 text-white">
      <tr><th class="px-4 py-3 text-right">پروژه</th><th class="px-4 py-3 text-center">تأیید شده</th><th class="px-4 py-3 text-center">وصول شده</th><th class="px-4 py-3 text-center">باقی‌مانده</th><th class="px-4 py-3 text-center">درصد وصول</th></tr>
    </thead>
    <tbody>
      @foreach($projects as $project)
        @php
          $approved = $project->total_approved ?? 0;
          $collected = $project->total_collected ?? 0;
          $outstanding = $approved - $collected;
          $percent = $approved > 0 ? round(($collected / $approved) * 100, 1) : 0;
        @endphp
        <tr class="border-b">
          <td class="px-4 py-3">{{ $project->project_name }}</td>
          <td class="px-4 py-3 text-center">{{ number_format($approved) }}</td>
          <td class="px-4 py-3 text-center">{{ number_format($collected) }}</td>
          <td class="px-4 py-3 text-center">{{ number_format($outstanding) }}</td>
          <td class="px-4 py-3 text-center">{{ $percent }}%</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@include('reports._export')
@endsection
