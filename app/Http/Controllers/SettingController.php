<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Http\Requests\UpdateSettingRequest;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all();
        return view('settings.index', compact('settings'));
    }

    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        $setting->update($request->validated());
        return back()->with('message', 'تنظیمات به‌روزرسانی شد');
    }
}
