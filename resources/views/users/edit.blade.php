@extends('layouts.app')
@section('title', 'ویرایش کاربر')
@section('page_title', 'ویرایش کاربر')
@section('content')
<form method="POST" action="{{ route('users.update', $user) }}" class="bg-white rounded-lg shadow p-6 space-y-4 max-w-xl">
  @csrf @method('PUT')
  <div><label class="block text-sm mb-1">نام</label><input name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded-lg px-3 py-2"></div>
  <div><label class="block text-sm mb-1">ایمیل</label><input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded-lg px-3 py-2"></div>
  <div><label class="block text-sm mb-1">نقش</label>
    <select name="role_id" class="w-full border rounded-lg px-3 py-2">
      @foreach(\App\Models\Role::all() as $role)
        <option value="{{ $role->id }}" @selected($user->role_id == $role->id)>{{ $role->display_name ?? $role->name }}</option>
      @endforeach
    </select></div>
  <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">ذخیره</button>
</form>
@endsection
