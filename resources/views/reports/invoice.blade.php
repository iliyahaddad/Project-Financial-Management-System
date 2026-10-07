@extends('layouts.app')
@section('title', 'گزارش صورت‌وضعیت')
@section('page_title', 'گزارش صورت‌وضعیت')
@section('content')
@livewire('report.report-filter')
<div class="bg-white rounded-lg shadow overflow-hidden mt-4">
  <table class="min-w-full">
    <thead class="bg-slate-800 text-white">
      <tr><th class="px-4 py-3 text-right">پروژه</th><th class="px-4 py-3 text-center">صادر شده</th><th class="px-4 py-3 text-center">تأیید شده</th><th class="px-4 py-3 text-center">وصول شده</th><th class="px-4 py-3 text-center">باقی‌مانده</th></tr>
    </thead>
    <tbody>
      @foreach($projects as $project)
        <tr class="border-b">
          <td class="px-4 py-3">{{ $project->project_name }}</td>
          <td class="px-4 py-3 text-center">{{ number_format($project->total_invoiced ?? 0) }}</td>
          <td class="px-4 py-3 text-center">{{ number_format($project->total_approved ?? 0) }}</td>
          <td class="px-4 py-3 text-center">{{ number_format($project->total_collected ?? 0) }}</td>
          <td class="px-4 py-3 text-center">{{ number_format(($project->total_approved ?? 0) - ($project->total_collected ?? 0)) }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@include('reports._export')
@endsection
