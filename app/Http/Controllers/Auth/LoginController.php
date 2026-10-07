<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials + ['status' => 'active'], $request->boolean('remember'))) {
            $request->session()->regenerate();
            Auth::user()->forceFill(['last_login_at' => now()])->save();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['email' => 'ایمیل یا رمز عبور نادرست است.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
