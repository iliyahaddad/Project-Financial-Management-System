<aside class="w-64 bg-slate-900 text-white flex flex-col">
  <div class="p-4 border-b border-slate-700">
    <h1 class="text-xl font-bold">مالی</h1>
    <p class="text-xs text-slate-400">سیستم مدیریت پروژه</p>
  </div>
  <nav class="flex-1 p-4 space-y-1">
    <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 rounded hover:bg-slate-800 {{ request()->routeIs('dashboard') ? 'bg-slate-800' : '' }}">
      <span>📊</span> داشبورد
    </a>
    <div class="pt-2">
      <p class="px-3 text-xs text-slate-400 uppercase">پروژه‌ها</p>
      <a href="{{ route('projects.index') }}" class="block px-3 py-2 rounded hover:bg-slate-800 {{ request()->routeIs('projects.*') ? 'bg-slate-800' : '' }}">همه پروژه‌ها</a>
      <a href="{{ route('projects.create') }}" class="block px-3 py-2 rounded hover:bg-slate-800">پروژه جدید</a>
    </div>
    <div class="pt-2">
      <p class="px-3 text-xs text-slate-400 uppercase">کنترل پروژه</p>
      <a href="#" class="block px-3 py-2 rounded hover:bg-slate-800">پیشرفت</a>
      <a href="#" class="block px-3 py-2 rounded hover:bg-slate-800">نفرروز</a>
      <a href="#" class="block px-3 py-2 rounded hover:bg-slate-800">هزینه</a>
    </div>
    <div class="pt-2">
      <p class="px-3 text-xs text-slate-400 uppercase">مالی پروژه</p>
      <a href="#" class="block px-3 py-2 rounded hover:bg-slate-800">صورت‌وضعیت</a>
      <a href="#" class="block px-3 py-2 rounded hover:bg-slate-800">وصول</a>
      <a href="#" class="block px-3 py-2 rounded hover:bg-slate-800">سودآوری</a>
      <a href="#" class="block px-3 py-2 rounded hover:bg-slate-800">پیش‌بینی</a>
    </div>
    <a href="{{ route('alerts.index') }}" class="flex items-center px-3 py-2 rounded hover:bg-slate-800 {{ request()->routeIs('alerts.*') ? 'bg-slate-800' : '' }}">
      <span>🔔</span> هشدارها
      @php
        $openAlerts = \App\Models\Alert::where('status', 'open')->count();
      @endphp
      @if($openAlerts > 0)
        <span class="mr-auto bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $openAlerts }}</span>
      @endif
    </a>
    <a href="{{ route('reports.index') }}" class="flex items-center px-3 py-2 rounded hover:bg-slate-800 {{ request()->routeIs('reports.*') ? 'bg-slate-800' : '' }}">
      <span>📈</span> گزارش‌ها
    </a>
    <a href="{{ route('projects.index') }}" class="flex items-center px-3 py-2 rounded hover:bg-slate-800 {{ request()->routeIs('documents.*') ? 'bg-slate-800' : '' }}">
      <span>📁</span> اسناد
    </a>
    @can('view', \App\Models\Setting::class)
      <a href="{{ route('settings.index') }}" class="flex items-center px-3 py-2 rounded hover:bg-slate-800 {{ request()->routeIs('settings.*') ? 'bg-slate-800' : '' }}">
        <span>⚙️</span> تنظیمات
      </a>
    @endcan
    @can('view', \App\Models\User::class)
      <a href="{{ route('users.index') }}" class="flex items-center px-3 py-2 rounded hover:bg-slate-800 {{ request()->routeIs('users.*') ? 'bg-slate-800' : '' }}">
        <span>👥</span> کاربران
      </a>
    @endcan
  </nav>
  <div class="p-4 border-t border-slate-700">
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="w-full text-right px-3 py-2 rounded hover:bg-slate-800 text-sm">خروج</button>
    </form>
  </div>
</aside>
