<header class="bg-white shadow px-6 py-3 flex items-center justify-between">
  <div class="flex items-center gap-4">
    <button class="md:hidden text-xl">☰</button>
    <h2 class="text-lg font-semibold">@yield('page_title', 'داشبورد')</h2>
  </div>
  <div class="flex items-center gap-4">
    <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">{{ auth()->user()->role->display_name ?? auth()->user()->role->name }}</span>
  </div>
</header>
