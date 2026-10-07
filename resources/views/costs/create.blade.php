@extends('layouts.app')
@section('title', 'ثبت هزینه جدید')
@section('page_title', 'ثبت هزینه جدید')
@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
  <form method="POST" action="{{ route('costs.store') }}" class="space-y-4">
    @csrf
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">پروژه</label>
      <select name="project_id" class="w-full border rounded-lg px-3 py-2" required>
        <option value="">انتخاب کنید</option>
        @foreach(\App\Models\Project::all() as $project)
          <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>{{ $project->project_name }}</option>
        @endforeach
      </select>
      @error('project_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">تاریخ</label>
        <input type="text" name="date" value="{{ old('date') }}" class="w-full border rounded-lg px-3 py-2" placeholder="1404/01/01" required>
        @error('date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">دسته هزینه</label>
        <select name="cost_category_id" class="w-full border rounded-lg px-3 py-2">
          <option value="">انتخاب کنید</option>
          @foreach(\App\Models\CostCategory::all() as $cat)
            <option value="{{ $cat->id }}" {{ old('cost_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->display_name ?? $cat->name }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">توضیحات</label>
      <input type="text" name="description" value="{{ old('description') }}" class="w-full border rounded-lg px-3 py-2" required>
      @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">مبلغ بودجه</label>
        <input type="number" name="budget_amount" value="{{ old('budget_amount') }}" class="w-full border rounded-lg px-3 py-2" step="0.01">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">مبلغ واقعی</label>
        <input type="number" name="actual_amount" value="{{ old('actual_amount') }}" class="w-full border rounded-lg px-3 py-2" step="0.01">
      </div>
    </div>
    <div class="flex justify-end gap-2">
      <a href="{{ route('costs.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-50">انصراف</a>
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">ثبت هزینه</button>
    </div>
  </form>
</div>
@endsection
