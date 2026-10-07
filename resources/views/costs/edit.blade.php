@extends('layouts.app')
@section('title', 'ویرایش هزینه')
@section('page_title', 'ویرایش هزینه')
@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
  <form method="POST" action="{{ route('costs.update', $cost) }}" class="space-y-4">
    @csrf
    @method('PUT')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">مبلغ بودجه</label>
        <input type="number" name="budget_amount" value="{{ old('budget_amount', $cost->budget_amount) }}" class="w-full border rounded-lg px-3 py-2" step="0.01">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">مبلغ واقعی</label>
        <input type="number" name="actual_amount" value="{{ old('actual_amount', $cost->actual_amount) }}" class="w-full border rounded-lg px-3 py-2" step="0.01">
      </div>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">توضیحات</label>
      <input type="text" name="description" value="{{ old('description', $cost->description) }}" class="w-full border rounded-lg px-3 py-2">
    </div>
    <div class="flex justify-end gap-2">
      <a href="{{ route('costs.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-50">انصراف</a>
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">ذخیره</button>
    </div>
  </form>
</div>
@endsection
