@extends('layouts.app')
@section('title', 'هشدار')
@section('page_title', 'جزئیات هشدار')
@section('content')
<div class="bg-white rounded-lg shadow p-6 space-y-2">
  <p>پروژه: {{ $alert->project->project_name ?? '-' }}</p>
  <p>نوع: {{ $alert->alert_type }} | شدت: {{ status_label($alert->severity) }}</p>
  <p>{{ $alert->message }}</p>
  <div class="flex gap-2">
    <form method="POST" action="{{ route('alerts.acknowledge', $alert) }}">@csrf<button class="px-4 py-2 bg-yellow-500 text-white rounded-lg">تایید دریافت</button></form>
    <form method="POST" action="{{ route('alerts.resolve', $alert) }}">@csrf<button class="px-4 py-2 bg-green-600 text-white rounded-lg">رفع شد</button></form>
  </div>
</div>
@endsection
