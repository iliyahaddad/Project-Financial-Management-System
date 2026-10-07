<div>
  <div class="bg-white rounded-lg shadow p-4 mb-4 flex gap-4">
    <input type="text" wire:model="search" placeholder="جستجوی پروژه..." class="border rounded-lg px-3 py-2 flex-1">
    <select wire:model="statusFilter" class="border rounded-lg px-3 py-2">
      <option value="">همه وضعیت‌ها</option>
      <option value="draft">پیش‌نویس</option>
      <option value="active">فعال</option>
      <option value="suspended">متوقف</option>
      <option value="completed">خاتمه‌یافته</option>
      <option value="cancelled">فسخ‌شده</option>
    </select>
  </div>
  <div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full">
      <thead class="bg-slate-800 text-white">
        <tr>
          <th class="px-4 py-3 text-right">کد پروژه</th>
          <th class="px-4 py-3 text-right">نام پروژه</th>
          <th class="px-4 py-3 text-right">کارفرما</th>
          <th class="px-4 py-3 text-center">وضعیت</th>
          <th class="px-4 py-3 text-center">پیشرفت</th>
          <th class="px-4 py-3 text-center">عملیات</th>
        </tr>
      </thead>
      <tbody>
        @forelse($projects as $project)
          <tr class="border-b hover:bg-gray-50">
            <td class="px-4 py-3">{{ $project->project_code }}</td>
            <td class="px-4 py-3">{{ $project->project_name }}</td>
            <td class="px-4 py-3">{{ $project->client->name ?? '-' }}</td>
            <td class="px-4 py-3 text-center">
              @php
                $color = match($project->status) {
                  'active' => 'bg-green-100 text-green-800',
                  'suspended' => 'bg-red-100 text-red-800',
                  'completed' => 'bg-blue-100 text-blue-800',
                  'cancelled' => 'bg-gray-100 text-gray-800',
                  default => 'bg-yellow-100 text-yellow-800',
                };
                $labels = ['draft'=>'پیش‌نویس','active'=>'فعال','suspended'=>'متوقف','completed'=>'خاتمه','cancelled'=>'فسخ','pending_start'=>'منتظر'];
              @endphp
              <span class="px-2 py-1 rounded-full text-xs font-medium {{ $color }}">{{ $labels[$project->status] ?? $project->status }}</span>
            </td>
            <td class="px-4 py-3 text-center">{{ number_format($project->actual_progress ?? 0, 1) }}%</td>
            <td class="px-4 py-3 text-center">
              <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:underline text-sm">مشاهده</a>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">پروژه‌ای یافت نشد</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="mt-4">{{ $projects->links() }}</div>
</div>
