@extends('layouts.app')
@section('title', 'گزارش پیش‌بینی')
@section('page_title', 'گزارش پیش‌بینی')
@section('content')
@livewire('report.report-filter')
<div class="bg-white rounded-lg shadow overflow-hidden mt-4">
  <table class="min-w-full">
    <thead class="bg-slate-800 text-white">
      <tr><th class="px-4 py-3 text-right">پروژه</th><th class="px-4 py-3 text-center">هزینه تا کنون</th><th class="px-4 py-3 text-center">EAC</th><th class="px-4 py-3 text-center">سود پیش‌بینی</th><th class="px-4 py-3 text-center">حاشیه سود</th></tr>
    </thead>
    <tbody>
      @foreach($projects as $project)
        @php
          $eac = $project->selected_eac ?? $project->eac_system ?? 0;
          $profit = ($project->contract_amount ?? 0) - $eac;
          $margin = ($project->contract_amount ?? 0) > 0 ? round(($profit / ($project->contract_amount ?? 1)) * 100, 1) : 0;
        @endphp
        <tr class="border-b">
          <td class="px-4 py-3">{{ $project->project_name }}</td>
          <td class="px-4 py-3 text-center">{{ number_format($project->actual_cost ?? 0) }}</td>
          <td class="px-4 py-3 text-center">{{ number_format($eac) }}</td>
          <td class="px-4 py-3 text-center">{{ number_format($profit) }}</td>
          <td class="px-4 py-3 text-center">{{ $margin }}%</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@include('reports._export')
@endsection
