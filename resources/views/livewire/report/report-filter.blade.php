<form method="GET" action="{{ url()->current() }}" class="bg-white rounded-lg shadow p-4">
  <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">کارفرما</label>
      <select name="client_id" class="w-full border rounded-lg px-3 py-2">
        <option value="">همه</option>
        @foreach($clients as $client)
          <option value="{{ $client->id }}" @selected(request('client_id') == $client->id)>{{ $client->name }}</option>
        @endforeach
      </select>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">شروع از (میلادی)</label>
      <input type="date" name="start_date_from" value="{{ request('start_date_from') }}" class="w-full border rounded-lg px-3 py-2">
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">شروع تا (میلادی)</label>
      <input type="date" name="start_date_to" value="{{ request('start_date_to') }}" class="w-full border rounded-lg px-3 py-2">
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">وضعیت</label>
      <select name="status" class="w-full border rounded-lg px-3 py-2">
        <option value="">همه</option>
        @foreach(['active' => 'فعال', 'completed' => 'خاتمه‌یافته', 'suspended' => 'متوقف', 'draft' => 'پیش‌نویس'] as $v => $l)
          <option value="{{ $v }}" @selected(request('status') === $v)>{{ $l }}</option>
        @endforeach
      </select>
    </div>
    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">اعمال فیلتر</button>
  </div>
</form>
