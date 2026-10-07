@extends('layouts.app')
@section('title', 'تنظیمات')
@section('page_title', 'تنظیمات سیستم')
@section('content')
<div class="bg-white rounded-lg shadow p-6">
  <h3 class="font-semibold mb-4">تنظیمات آستانه‌ها</h3>
  <form method="POST" action="{{ route('settings.update') }}" class="space-y-4">
    @csrf
    @method('PUT')
    @foreach($settings as $setting)
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">{{ $setting->description ?? $setting->key }}</label>
          <input type="text" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}" class="w-full border rounded-lg px-3 py-2">
        </div>
      </div>
    @endforeach
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">ذخیره</button>
  </form>
</div>
@endsection
