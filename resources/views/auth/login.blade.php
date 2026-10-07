<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>ورود | مالی</title>
  <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>body { font-family: 'Vazirmatn', sans-serif; }</style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center">
  <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md">
    <div class="text-center mb-8">
      <h1 class="text-3xl font-bold text-slate-800">مالی</h1>
      <p class="text-gray-500 mt-2">سیستم مدیریت پروژه و مالی</p>
    </div>
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
      @csrf
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">ایمیل</label>
        <input type="email" name="email" class="w-full border rounded-lg px-3 py-2" required autofocus>
        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">رمز عبور</label>
        <input type="password" name="password" class="w-full border rounded-lg px-3 py-2" required>
        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>
      <div class="flex items-center justify-between">
        <label class="flex items-center gap-2">
          <input type="checkbox" name="remember" class="rounded">
          <span class="text-sm">مرا به خاطر بسپار</span>
        </label>
      </div>
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">ورود</button>
    </form>
  </div>
</body>
</html>
