<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'داشبورد مدیریت') | مالی</title>
  <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  @livewireStyles
  <style>
    body { font-family: 'Vazirmatn', sans-serif; }
  </style>
</head>
<body class="bg-gray-100">
  <div class="flex min-h-screen">
    @include('layouts.sidebar')
    <div class="flex-1 flex flex-col">
      @include('layouts.topbar')
      <main class="flex-1 p-6">
        @if(session('message'))
          <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('message') }}</div>
        @endif
        @if(session('error'))
          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
        @endif
        @yield('content')
      </main>
    </div>
  </div>
  @livewireScripts
  @vite('resources/js/app.js')
</body>
</html>
