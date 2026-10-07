@extends('layouts.app')
@section('title', 'داشبورد')
@section('page_title', 'داشبورد مدیریت')
@section('content')
<div class="space-y-6">
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white rounded-lg shadow p-6">
      <p class="text-sm text-gray-500">تعداد پروژه‌ها</p>
      <p class="text-3xl font-bold text-blue-600">{{ $stats['total_projects'] ?? 0 }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
      <p class="text-sm text-gray-500">ارزش کل قراردادها</p>
      <p class="text-3xl font-bold text-green-600">{{ number_format($stats['total_contract_value'] ?? 0) }} ریال</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
      <p class="text-sm text-gray-500">هزینه واقعی</p>
      <p class="text-3xl font-bold text-red-600">{{ number_format($stats['total_actual_cost'] ?? 0) }} ریال</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
      <p class="text-sm text-gray-500">سود پیش‌بینی‌شده</p>
      <p class="text-3xl font-bold text-purple-600">{{ number_format($stats['total_forecast_profit'] ?? 0) }} ریال</p>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
      <h3 class="text-lg font-semibold mb-4">وضعیت پروژه‌ها</h3>
      <canvas id="projectStatusChart"></canvas>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
      <h3 class="text-lg font-semibold mb-4">هزینه vs بودجه</h3>
      <canvas id="budgetCostChart"></canvas>
    </div>
  </div>

  <div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b">
      <h3 class="text-lg font-semibold">جدول وضعیت پروژه‌ها</h3>
    </div>
    <div class="p-6">
      @livewire('dashboard.project-table')
    </div>
  </div>
</div>

@push('scripts')
<script>
  const statusCtx = document.getElementById('projectStatusChart');
  if (statusCtx) {
    new Chart(statusCtx, {
      type: 'doughnut',
      data: {
        labels: ['عادی', 'هشدار', 'بحرانی'],
        datasets: [{
          data: [{{ $stats['normal_count'] ?? 0 }}, {{ $stats['warning_count'] ?? 0 }}, {{ $stats['critical_count'] ?? 0 }}],
          backgroundColor: ['#10b981', '#f59e0b', '#ef4444']
        }]
      },
      options: { responsive: true, plugins: { legend: { position: 'bottom', labels: { font: { family: 'Vazirmatn' } } } } }
    });
  }

  const budgetCtx = document.getElementById('budgetCostChart');
  if (budgetCtx) {
    new Chart(budgetCtx, {
      type: 'bar',
      data: {
        labels: {!! json_encode($stats['project_names'] ?? []) !!},
        datasets: [
          { label: 'بودجه', data: {!! json_encode($stats['budgets'] ?? []) !!}, backgroundColor: '#3b82f6' },
          { label: 'هزینه واقعی', data: {!! json_encode($stats['actual_costs'] ?? []) !!}, backgroundColor: '#ef4444' }
        ]
      },
      options: { responsive: true, plugins: { legend: { labels: { font: { family: 'Vazirmatn' } } } } }
    });
  }
@endpush
@endsection
