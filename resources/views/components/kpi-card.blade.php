@props([
    'title',
    'value',
    'change' => null,
    'changeType' => 'neutral',
    'icon' => null,
])

@php
$changeColors = [
    'up' => 'text-green-600',
    'down' => 'text-red-600',
    'neutral' => 'text-gray-600',
];

$changeIcons = [
    'up' => '↑',
    'down' => '↓',
    'neutral' => '→',
];

$bgColors = [
    'blue' => 'bg-blue-50 border-blue-200',
    'green' => 'bg-green-50 border-green-200',
    'yellow' => 'bg-yellow-50 border-yellow-200',
    'red' => 'bg-red-50 border-red-200',
    'gray' => 'bg-gray-50 border-gray-200',
];
@endphp

<div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow">
    <div class="flex items-center justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-600">{{ $title }}</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $value }}</p>
            @if($change !== null)
            <p class="text-sm mt-1 {{ $changeColors[$changeType] ?? $changeColors['neutral'] }}">
                {{ $changeIcons[$changeType] ?? '→' }} {{ $change }}
            </p>
            @endif
        </div>
        @if($icon)
        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600">
            {!! $icon !!}
        </div>
        @endif
    </div>
</div>
