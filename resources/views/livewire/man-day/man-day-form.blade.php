<div>
  <form wire:submit="save" class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">دوره</label>
        <input type="text" wire:model="period" class="w-full border rounded-lg px-3 py-2" required>
        @error('period') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">نفرروز برنامه‌ای</label>
        <input type="number" wire:model="planned_man_days" class="w-full border rounded-lg px-3 py-2" step="0.01" required>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">نفرروز واقعی</label>
        <input type="number" wire:model="actual_man_days" class="w-full border rounded-lg px-3 py-2" step="0.01" required>
      </div>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">توضیحات</label>
      <textarea wire:model="notes" rows="3" class="w-full border rounded-lg px-3 py-2"></textarea>
    </div>
    <div class="flex justify-end">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">ثبت نفرروز</button>
    </div>
  </form>
</div>
