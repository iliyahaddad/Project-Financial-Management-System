<div class="flex gap-2 mt-4">
  <a href="{{ request()->fullUrlWithQuery(['export' => 'excel']) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg">Excel</a>
  <a href="{{ request()->fullUrlWithQuery(['export' => 'pdf']) }}" class="px-4 py-2 bg-red-600 text-white rounded-lg">PDF</a>
</div>
