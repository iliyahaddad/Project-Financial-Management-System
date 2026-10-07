@extends('layouts.app')
@section('title', 'گزارش نفرروز')
@section('page_title', 'گزارش نفرروز')
@section('content')
@livewire('report.report-filter')
<div class="bg-white rounded-lg shadow overflow-hidden mt-4">
  <table class="min-w-full">
    <thead class="bg-slate-800 text-white">
      <tr><th class="px-4 py-3 text-right">پروژه</th><th class="px-4 py-3 text-center">قرارداد</th><th class="px-4 py-3 text-center">واقعی</th><th class="px-4 py-3 text-center">مصرف</th></tr>
    </thead>
    <tbody>
      @foreach($projects as $project)
        <tr class="border-b">
          <td class="px-4 py-3">{{ $project->project_name }}</td>
          <td class="px-4 py-3 text-center">{{ number_format($project->contract_man_days ?? 0) }}</td>
          <td class="px-4 py-3 text-center">{{ number_format($project->actual_man_days ?? 0) }}</td>
          <td class="px-4 py-3 text-center">{{ number_format($project->man_day_consumption ?? 0, 1) }}%</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@include('reports._export')
@endsection
