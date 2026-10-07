@extends('layouts.app')
@section('title', 'گزارش سودآوری')
@section('page_title', 'گزارش سودآوری')
@section('content')
@livewire('report.report-filter')
<div class="bg-white rounded-lg shadow overflow-hidden mt-4">
  <table class="min-w-full">
    <thead class="bg-slate-800 text-white">
      <tr><th class="px-4 py-3 text-right">پروژه</th><th class="px-4 py-3 text-center">درآمد</th><th class="px-4 py-3 text-center">هزینه</th><th class="px-4 py-3 text-center">سود خالص</th><th class="px-4 py-3 text-center">حاشیه سود</th></tr>
    </thead>
    <tbody>
      @foreach($projects as $project)
        @php
          $revenue = $project->final_contract_amount ?? $project->contracts->first()?->final_contract_amount ?? 0;
          $cost = $project->actual_cost ?? 0;
          $profit = $revenue - $cost;
          $margin = $revenue > 0 ? round(($profit / $revenue) * 100, 1) : 0;
        @endphp
        <tr class="border-b">
          <td class="px-4 py-3">{{ $project->project_name }}</td>
          <td class="px-4 py-3 text-center">{{ number_format($revenue) }}</td>
          <td class="px-4 py-3 text-center">{{ number_format($cost) }}</td>
          <td class="px-4 py-3 text-center">{{ number_format($profit) }}</td>
          <td class="px-4 py-3 text-center">
            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $margin < 15 ? 'bg-red-100 text-red-800' : ($margin < 25 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
              {{ $margin }}%
            </span>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@include('reports._export')
@endsection
