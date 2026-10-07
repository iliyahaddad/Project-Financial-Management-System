@extends('layouts.app')
@section('title', 'گزارش هزینه‌ها')
@section('page_title', 'گزارش هزینه‌ها')
@section('content')
@livewire('report.report-filter')
<div class="bg-white rounded-lg shadow overflow-hidden mt-4">
  <table class="min-w-full">
    <thead class="bg-slate-800 text-white">
      <tr><th class="px-4 py-3 text-right">پروژه</th><th class="px-4 py-3 text-center">بودجه</th><th class="px-4 py-3 text-center">هزینه واقعی</th><th class="px-4 py-3 text-center">انحراف</th></tr>
    </thead>
    <tbody>
      @foreach($projects as $project)
        @php $budget = $project->budget ?? 0; $actual = $project->actual_cost ?? 0; @endphp
        <tr class="border-b">
          <td class="px-4 py-3">{{ $project->project_name }}</td>
          <td class="px-4 py-3 text-center">{{ number_format($budget) }}</td>
          <td class="px-4 py-3 text-center">{{ number_format($actual) }}</td>
          <td class="px-4 py-3 text-center">{{ number_format($actual - $budget) }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@include('reports._export')
@endsection
