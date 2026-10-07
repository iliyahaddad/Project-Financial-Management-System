<div>
  <div class="bg-white rounded-lg shadow p-4 mb-4 flex gap-4">
    <select wire:model="severityFilter" class="border rounded-lg px-3 py-2">
      <option value="">همه شدت‌ها</option>
      <option value="info">اطلاع</option>
      <option value="warning">هشدار</option>
      <option value="critical">بحرانی</option>
    </select>
    <select wire:model="statusFilter" class="border rounded-lg px-3 py-2">
      <option value="">همه وضعیت‌ها</option>
      <option value="open">باز</option>
      <option value="acknowledged">تایید شده</option>
      <option value="resolved">حل شده</option>
    </select>
  </div>
  <div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full">
      <thead class="bg-slate-800 text-white">
        <tr>
          <th class="px-4 py-3 text-right">پروژه</th>
          <th class="px-4 py-3 text-right">نوع</th>
          <th class="px-4 py-3 text-center">شدت</th>
          <th class="px-4 py-3 text-right">پیام</th>
          <th class="px-4 py-3 text-center">تاریخ</th>
          <th class="px-4 py-3 text-center">وضعیت</th>
        </tr>
      </thead>
      <tbody>
        @foreach($alerts as $alert)
          <tr class="border-b hover:bg-gray-50">
            <td class="px-4 py-3">{{ $alert->project->project_name ?? '-' }}</td>
            <td class="px-4 py-3">{{ $alert->alert_type }}</td>
            <td class="px-4 py-3 text-center">
              @php
                $color = match($alert->severity) {
                  'critical' => 'bg-red-100 text-red-800',
                  'warning' => 'bg-yellow-100 text-yellow-800',
                  default => 'bg-blue-100 text-blue-800',
                };
              @endphp
              <span class="px-2 py-1 rounded-full text-xs font-medium {{ $color }}">{{ $alert->severity }}</span>
            </td>
            <td class="px-4 py-3">{{ Str::limit($alert->message, 50) }}</td>
            <td class="px-4 py-3 text-center">{{ $alert->detected_at }}</td>
            <td class="px-4 py-3 text-center">
              @php
                $labels = ['open'=>'باز','acknowledged'=>'تایید شده','resolved'=>'حل شده','dismissed'=>'رد شده'];
              @endphp
              {{ $labels[$alert->status] ?? $alert->status }}
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="mt-4">{{ $alerts->links() }}</div>
</div>
