@extends('layouts.app')
@section('title', 'گزارش‌ها')
@section('page_title', 'گزارش‌ها')
@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
  <a href="{{ route('reports.project-status') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
    <div class="text-3xl mb-2">📊</div>
    <h3 class="font-semibold">وضعیت پروژه‌ها</h3>
    <p class="text-sm text-gray-500 mt-1">گزارش کلی وضعیت تمام پروژه‌ها</p>
  </a>
  <a href="{{ route('reports.cost') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
    <div class="text-3xl mb-2">💰</div>
    <h3 class="font-semibold">گزارش هزینه‌ها</h3>
    <p class="text-sm text-gray-500 mt-1">مقایسه بودجه و هزینه واقعی</p>
  </a>
  <a href="{{ route('reports.man-day') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
    <div class="text-3xl mb-2">👷</div>
    <h3 class="font-semibold">گزارش نفرروز</h3>
    <p class="text-sm text-gray-500 mt-1">مصرف نفرروز و بازه</p>
  </a>
  <a href="{{ route('reports.invoice') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
    <div class="text-3xl mb-2">🧾</div>
    <h3 class="font-semibold">گزارش صورت‌وضعیت</h3>
    <p class="text-sm text-gray-500 mt-1">وضعیت صورتحساب‌ها</p>
  </a>
  <a href="{{ route('reports.collection') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
    <div class="text-3xl mb-2">💵</div>
    <h3 class="font-semibold">گزارش وصول</h3>
    <p class="text-sm text-gray-500 mt-1">وضعیت مطالبات و وصول</p>
  </a>
  <a href="{{ route('reports.profitability') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
    <div class="text-3xl mb-2">📈</div>
    <h3 class="font-semibold">گزارش سودآوری</h3>
    <p class="text-sm text-gray-500 mt-1">سود و حاشیه سود پروژه‌ها</p>
  </a>
  <a href="{{ route('reports.forecast') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
    <div class="text-3xl mb-2">🔮</div>
    <h3 class="font-semibold">گزارش پیش‌بینی</h3>
    <p class="text-sm text-gray-500 mt-1">EAC و پیش‌بینی سود</p>
  </a>
  <a href="{{ route('reports.forecast') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
    <div class="text-3xl mb-2">📋</div>
    <h3 class="font-semibold">گزارش P&L</h3>
    <p class="text-sm text-gray-500 mt-1">صورت سود و زیان پروژه</p>
  </a>
  <a href="#" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
    <div class="text-3xl mb-2">⚖️</div>
    <h3 class="font-semibold">مقایسه پروژه‌ها</h3>
    <p class="text-sm text-gray-500 mt-1">مقایسه lado-lado پروژه‌ها</p>
  </a>
</div>
@endsection
