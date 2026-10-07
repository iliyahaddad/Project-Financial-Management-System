@extends('layouts.app')
@section('title', $project->project_name)
@section('page_title', $project->project_name)
@section('content')
<div class="space-y-6">
  <div class="bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div>
        <p class="text-sm text-gray-500">کد پروژه</p>
        <p class="font-semibold">{{ $project->project_code }}</p>
      </div>
      <div>
        <p class="text-sm text-gray-500">کارفرما</p>
        <p class="font-semibold">{{ $project->client->name ?? '-' }}</p>
      </div>
      <div>
        <p class="text-sm text-gray-500">تاریخ شروع</p>
        <p class="font-semibold">{{ $project->start_date ?? '-' }}</p>
      </div>
      <div>
        <p class="text-sm text-gray-500">تاریخ پایان</p>
        <p class="font-semibold">{{ $project->end_date ?? '-' }}</p>
      </div>
    </div>
  </div>

  @livewire('project.project-kpi', ['project' => $project])

  <div class="bg-white rounded-lg shadow">
    <div class="border-b">
      <nav class="flex gap-4 px-6">
        <button class="py-3 border-b-2 border-blue-600 font-medium">پیشرفت</button>
        <button class="py-3 text-gray-500 hover:text-gray-700">نفرروز</button>
        <button class="py-3 text-gray-500 hover:text-gray-700">هزینه‌ها</button>
        <button class="py-3 text-gray-500 hover:text-gray-700">صورت‌وضعیت</button>
        <button class="py-3 text-gray-500 hover:text-gray-700">پیش‌بینی</button>
        <button class="py-3 text-gray-500 hover:text-gray-700">سودآوری</button>
      </nav>
    </div>
    <div class="p-6">
      <h4 class="font-semibold mb-4">ثبت پیشرفت جدید</h4>
      @livewire('progress.progress-form', ['project' => $project])
    </div>
  </div>
</div>
@endsection
