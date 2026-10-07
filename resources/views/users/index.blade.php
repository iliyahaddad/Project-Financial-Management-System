@extends('layouts.app')
@section('title', 'کاربران')
@section('page_title', 'مدیریت کاربران')
@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
  <div class="px-6 py-4 border-b flex justify-between items-center">
    <h3 class="font-semibold">لیست کاربران</h3>
    <a href="{{ route('users.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">کاربر جدید</a>
  </div>
  <table class="min-w-full">
    <thead class="bg-slate-800 text-white">
      <tr><th class="px-4 py-3 text-right">نام</th><th class="px-4 py-3 text-right">ایمیل</th><th class="px-4 py-3 text-center">نقش</th><th class="px-4 py-3 text-center">وضعیت</th></tr>
    </thead>
    <tbody>
      @foreach($users as $user)
        <tr class="border-b">
          <td class="px-4 py-3">{{ $user->name }}</td>
          <td class="px-4 py-3">{{ $user->email }}</td>
          <td class="px-4 py-3 text-center">{{ $user->role->display_name ?? '-' }}</td>
          <td class="px-4 py-3 text-center">
            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
              {{ $user->status === 'active' ? 'فعال' : 'غیرفعال' }}
            </span>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
