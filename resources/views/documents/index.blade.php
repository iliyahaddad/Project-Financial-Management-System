@extends('layouts.app')
@section('title', 'اسناد پروژه')
@section('page_title', 'اسناد پروژه')
@section('content')
<div class="space-y-4">
  <div class="bg-white rounded-lg shadow p-6">
    <h3 class="font-semibold mb-4">آپلود سند جدید</h3>
    <form method="POST" action="{{ route('projects.documents.store', $project) }}" enctype="multipart/form-data" class="space-y-4">
      @csrf
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">نام سند</label>
        <input type="text" name="name" class="w-full border rounded-lg px-3 py-2" required>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">نوع سند</label>
        <select name="document_type" class="w-full border rounded-lg px-3 py-2">
          <option value="contract">قرارداد</option>
          <option value="invoice">صورت‌وضعیت</option>
          <option value="cost">هزینه</option>
          <option value="report">گزارش</option>
          <option value="other">سایر</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">فایل</label>
        <input type="file" name="file" class="w-full border rounded-lg px-3 py-2" required>
      </div>
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">آپلود</button>
    </form>
  </div>
  <div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full">
      <thead class="bg-slate-800 text-white">
        <tr><th class="px-4 py-3 text-right">نام</th><th class="px-4 py-3 text-center">نوع</th><th class="px-4 py-3 text-center">تاریخ</th></tr>
      </thead>
      <tbody>
        @forelse($project->documents as $doc)
          <tr class="border-b">
            <td class="px-4 py-3">{{ $doc->name }}</td>
            <td class="px-4 py-3 text-center">{{ $doc->document_type }}</td>
            <td class="px-4 py-3 text-center">{{ $doc->created_at }}</td>
          </tr>
        @empty
          <tr><td colspan="3" class="px-4 py-8 text-center text-gray-500">سندی آپلود نشده</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
