<div class="bg-white rounded-lg shadow p-6 flex items-center justify-between">
  <div>
    <p class="text-sm text-gray-500">{{ $title }}</p>
    <p class="text-2xl font-bold mt-1">{{ $value }}</p>
    @if($change)
      <p class="text-sm mt-1 {{ $change > 0 ? 'text-green-600' : ($change < 0 ? 'text-red-600' : 'text-gray-500') }}">
        {{ $change > 0 ? '+' : '' }}{{ $change }}%
      </p>
    @endif
  </div>
  @if($icon)
    <div class="text-3xl opacity-20">{{ $icon }}</div>
  @endif
</div>
