@php
  $k = app(\App\Services\ProjectMetricsService::class)->getAllMetrics($project);
  $cards = [
    'پیشرفت (انحراف)' => number_format($k['progress_variance'] ?? 0, 1) . '%',
    'زمان' => number_format($k['time_progress'] ?? 0, 1) . '%',
    'نفرروز' => number_format($k['man_day_consumption']['consumption_percent'] ?? 0, 1) . '%',
    'هزینه (انحراف)' => number_format($k['cost_consumption']['variance_percent'] ?? 0, 1) . '%',
    'صورت‌وضعیت' => number_format($k['invoice_metrics']['total_invoiced'] ?? 0),
    'وصول' => number_format($k['invoice_metrics']['collection_percent'] ?? 0, 1) . '%',
    'سودآوری' => number_format($k['forecast_profit']['forecast_margin'] ?? 0, 1) . '%',
  ];
@endphp
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
  @foreach($cards as $label => $value)
    <div class="bg-white rounded-lg shadow p-4">
      <p class="text-sm text-gray-500">{{ $label }}</p>
      <p class="text-xl font-bold">{{ $value }}</p>
    </div>
  @endforeach
</div>
