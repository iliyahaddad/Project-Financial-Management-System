<div>
  <form wire:submit="save" class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">تاریخ پیش‌بینی</label>
        <input type="text" wire:model="forecast_date" class="w-full border rounded-lg px-3 py-2" required>
        @error('forecast_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">مدل پیش‌بینی</label>
        <select wire:model="model_type" class="w-full border rounded-lg px-3 py-2">
          <option value="progress_based">بر اساس پیشرفت</option>
          <option value="budget_based">بر اساس بودجه</option>
          <option value="manual">دستی</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">هزینه تا کنون</label>
        <input type="number" wire:model="actual_cost_to_date" class="w-full border rounded-lg px-3 py-2" step="0.01">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">پیشرفت (%)</label>
        <input type="number" wire:model="actual_progress" class="w-full border rounded-lg px-3 py-2" step="0.01">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">EAC دستی (در صورت انتخاب مدل دستی)</label>
        <input type="number" wire:model="manual_eac" class="w-full border rounded-lg px-3 py-2" step="0.01">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">بودجه باقی‌مانده</label>
        <input type="number" wire:model="budget_cost" class="w-full border rounded-lg px-3 py-2" step="0.01">
      </div>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">دلیل تغییر دستی</label>
      <textarea wire:model="reason_for_override" rows="2" class="w-full border rounded-lg px-3 py-2"></textarea>
    </div>
    <div class="flex justify-end">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">ثبت پیش‌بینی</button>
    </div>
  </form>
</div>
