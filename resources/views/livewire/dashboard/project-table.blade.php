<div>
  <div class="overflow-x-auto">
    <table class="min-w-full bg-white rounded-lg shadow">
      <thead>
        <tr class="bg-slate-800 text-white">
          <th class="px-4 py-3 text-right">پروژه</th>
          <th class="px-4 py-3 text-right">کارفرما</th>
          <th class="px-4 py-3 text-center">پیشرفت</th>
          <th class="px-4 py-3 text-center">زمان</th>
          <th class="px-4 py-3 text-center">نفرروز</th>
          <th class="px-4 py-3 text-center">هزینه</th>
          <th class="px-4 py-3 text-center">سود پیش‌بینی</th>
          <th class="px-4 py-3 text-center">وصول</th>
          <th class="px-4 py-3 text-center">وضعیت</th>
        </tr>
      </thead>
      <tbody>
        @foreach($projects as $project)
          <tr class="border-b hover:bg-gray-50">
            <td class="px-4 py-3">
              <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:underline font-medium">
                {{ $project->project_name }}
              </a>
              <div class="text-xs text-gray-500">{{ $project->project_code }}</div>
            </td>
            <td class="px-4 py-3">{{ $project->client->name ?? '-' }}</td>
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
  <div class="mt-4">{{ $projects->links() }}</div>
</div>
