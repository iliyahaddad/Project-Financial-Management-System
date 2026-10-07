<div>
  <form wire:submit="save" class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">نام WBS</label>
        <input type="text" wire:model="name" class="w-full border rounded-lg px-3 py-2" required>
        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">کد</label>
        <input type="text" wire:model="code" class="w-full border rounded-lg px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">بودجه</label>
        <input type="number" wire:model="budget" class="w-full border rounded-lg px-3 py-2" step="0.01">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">وزن (%)</label>
        <input type="number" wire:model="weight" class="w-full border rounded-lg px-3 py-2" step="0.01">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">پیشرفت برنامه‌ای</label>
        <input type="number" wire:model="planned_progress" class="w-full border rounded-lg px-3 py-2" step="0.01">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">پیشرفت واقعی</label>
        <input type="number" wire:model="actual_progress" class="w-full border rounded-lg px-3 py-2" step="0.01">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">وضعیت</label>
        <select wire:model="status" class="w-full border rounded-lg px-3 py-2">
          <option value="not_started">شروع نشده</option>
          <option value="in_progress">در حال اجرا</option>
          <option value="completed">تکمیل شده</option>
          <option value="on_hold">متوقف</option>
        </select>
      </div>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">توضیحات</label>
      <textarea wire:model="description" rows="3" class="w-full border rounded-lg px-3 py-2"></textarea>
    </div>
    <div class="flex justify-end">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">ذخیره</button>
    </div>
  </form>
</div>
