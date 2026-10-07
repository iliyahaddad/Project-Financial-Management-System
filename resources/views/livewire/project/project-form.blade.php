<div>
  <form wire:submit="save" class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">کد پروژه</label>
        <input type="text" wire:model="project_code" class="w-full border rounded-lg px-3 py-2" required>
        @error('project_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">نام پروژه</label>
        <input type="text" wire:model="project_name" class="w-full border rounded-lg px-3 py-2" required>
        @error('project_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">کارفرما</label>
        <select wire:model="client_id" class="w-full border rounded-lg px-3 py-2" required>
          <option value="">انتخاب کنید</option>
          @foreach(\App\Models\Client::all() as $client)
            <option value="{{ $client->id }}">{{ $client->name }}</option>
          @endforeach
        </select>
        @error('client_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">مدیر پروژه</label>
        <select wire:model="project_manager_id" class="w-full border rounded-lg px-3 py-2" required>
          <option value="">انتخاب کنید</option>
          @foreach(\App\Models\User::whereHas('role', fn($q) => $q->whereIn('name', ['project_manager','controller']))->get() as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
          @endforeach
        </select>
        @error('project_manager_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">تاریخ شروع</label>
        <input type="text" wire:model="start_date" class="w-full border rounded-lg px-3 py-2" placeholder="1404/01/01">
        @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">تاریخ پایان</label>
        <input type="text" wire:model="end_date" class="w-full border rounded-lg px-3 py-2" placeholder="1404/12/29">
        @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">وضعیت</label>
        <select wire:model="status" class="w-full border rounded-lg px-3 py-2">
          <option value="draft">پیش‌نویس</option>
          <option value="active">فعال</option>
          <option value="suspended">متوقف</option>
          <option value="pending_start">در انتظار شروع</option>
          <option value="completed">خاتمه‌یافته</option>
          <option value="cancelled">فسخ‌شده</option>
        </select>
        @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">اولویت</label>
        <select wire:model="priority" class="w-full border rounded-lg px-3 py-2">
          <option value="low">پایین</option>
          <option value="medium">متوسط</option>
          <option value="high">بالا</option>
          <option value="critical">بحرانی</option>
        </select>
        @error('priority') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">توضیحات</label>
      <textarea wire:model="description" rows="3" class="w-full border rounded-lg px-3 py-2"></textarea>
      @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
    <div class="flex justify-end gap-2">
      <a href="{{ route('projects.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-50">انصراف</a>
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">ذخیره</button>
    </div>
  </form>
</div>
