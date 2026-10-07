@extends('layouts.app')
@section('title', 'پروژه‌ها')
@section('page_title', 'پروژه‌ها')
@section('content')
<div class="flex justify-between mb-4">
  <h3 class="text-xl font-bold">لیست پروژه‌ها</h3>
  <a href="{{ route('projects.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">پروژه جدید</a>
</div>
<div class="bg-white rounded-lg shadow overflow-hidden">
  <table class="min-w-full">
    <thead class="bg-slate-800 text-white">
      <tr><th class="px-4 py-3 text-right">کد</th><th class="px-4 py-3 text-right">نام پروژه</th><th class="px-4 py-3 text-center">وضعیت</th><th class="px-4 py-3 text-center">عملیات</th></tr>
    </thead>
    <tbody>
      @forelse($projects as $project)
        <tr class="border-b">
          <td class="px-4 py-3">{{ $project->project_code }}</td>
          <td class="px-4 py-3">{{ $project->project_name }}</td>
          <td class="px-4 py-3 text-center">{{ status_label($project->status) }}</td>
          <td class="px-4 py-3 text-center">
            <a class="text-blue-600" href="{{ route('projects.show', $project) }}">مشاهده</a> |
            <a class="text-blue-600" href="{{ route('projects.edit', $project) }}">ویرایش</a>
          </td>
        </tr>
      @empty
        <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">پروژه‌ای ثبت نشده است</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
