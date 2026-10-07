@extends('layouts.app')
@section('title', 'کاربر جدید')
@section('page_title', 'کاربر جدید')
@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
  <form method="POST" action="{{ route('users.store') }}" class="space-y-4">
    @csrf
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">نام</label>
      <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded-lg px-3 py-2" required>
      @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">ایمیل</label>
      <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded-lg px-3 py-2" required>
      @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">رمز عبور</label>
      <input type="password" name="password" class="w-full border rounded-lg px-3 py-2" required>
      @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">تکرار رمز عبور</label>
      <input type="password" name="password_confirmation" class="w-full border rounded-lg px-3 py-2" required>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">نقش</label>
      <select name="role_id" class="w-full border rounded-lg px-3 py-2">
        <option value="">انتخاب کنید</option>
        @foreach(\App\Models\Role::all() as $role)
          <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->display_name ?? $role->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="flex justify-end gap-2">
      <a href="{{ route('users.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-50">انصراف</a>
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">ثبت کاربر</button>
    </div>
  </form>
</div>
@endsection
