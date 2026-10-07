<div>
  <form wire:submit="save" class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">شماره صورت‌وضعیت</label>
        <input type="text" wire:model="invoice_number" class="w-full border rounded-lg px-3 py-2" required>
        @error('invoice_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">دوره</label>
        <input type="text" wire:model="period" class="w-full border rounded-lg px-3 py-2" placeholder="1404/01">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">مبلغ صورت‌وضعیت</label>
        <input type="number" wire:model="invoice_amount" class="w-full border rounded-lg px-3 py-2" step="0.01" required>
      </div>
    </div>
    <div class="flex justify-end">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">ثبت صورت‌وضعیت</button>
    </div>
  </form>
</div>
