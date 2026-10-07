<div>
  <form wire:submit="save" class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">پروژه</label>
        <select wire:model="project_id" class="w-full border rounded-lg px-3 py-2" required>
          <option value="">انتخاب کنید</option>
          @foreach(\App\Models\Project::all() as $p)<option value="{{ $p->id }}">{{ $p->project_name }}</option>@endforeach
        </select>
        @error('project_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">تاریخ</label>
        <input type="date" wire:model="date" class="w-full border rounded-lg px-3 py-2" placeholder="YYYY-MM-DD" required>
        @error('date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">دسته هزینه</label>
        <select wire:model="cost_category_id" class="w-full border rounded-lg px-3 py-2">
          <option value="">انتخاب کنید</option>
          @foreach(\App\Models\CostCategory::all() as $cat)
            <option value="{{ $cat->id }}">{{ $cat->display_name ?? $cat->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">توضیحات</label>
        <input type="text" wire:model="description" class="w-full border rounded-lg px-3 py-2" required>
        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">مبلغ بودجه</label>
        <input type="number" wire:model="budget_amount" class="w-full border rounded-lg px-3 py-2" step="0.01">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">مبلغ واقعی</label>
        <input type="number" wire:model="actual_amount" class="w-full border rounded-lg px-3 py-2" step="0.01">
      </div>
    </div>
    <div class="flex justify-end">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">ثبت هزینه</button>
    </div>
  </form>
</div>
