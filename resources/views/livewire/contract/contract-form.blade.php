<div>
  <form wire:submit="save" class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">شماره قرارداد</label>
        <input type="text" wire:model="contract_number" class="w-full border rounded-lg px-3 py-2" required>
        @error('contract_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">نوع قرارداد</label>
        <select wire:model="contract_type" class="w-full border rounded-lg px-3 py-2">
          <option value="inspection">بازرسی</option>
          <option value="engineering">مهندسی</option>
          <option value="consulting">مشاوره</option>
          <option value="testing">تست</option>
          <option value="commissioning">راه‌اندازی</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">مبلغ قرارداد</label>
        <input type="number" wire:model="contract_amount" class="w-full border rounded-lg px-3 py-2" step="0.01" required>
        @error('contract_amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">نفرروز قرارداد</label>
        <input type="number" wire:model="contract_man_days" class="w-full border rounded-lg px-3 py-2" required>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">تاریخ شروع</label>
        <input type="text" wire:model="start_date" class="w-full border rounded-lg px-3 py-2" placeholder="1404/01/01">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">تاریخ پایان</label>
        <input type="text" wire:model="end_date" class="w-full border rounded-lg px-3 py-2" placeholder="1404/12/29">
      </div>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">توضیحات</label>
      <textarea wire:model="description" rows="3" class="w-full border rounded-lg px-3 py-2"></textarea>
    </div>
    <div class="flex justify-end gap-2">
      <a href="{{ route('projects.show', $project) }}" class="px-4 py-2 border rounded-lg hover:bg-gray-50">انصراف</a>
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">ذخیره</button>
    </div>
  </form>
</div>
