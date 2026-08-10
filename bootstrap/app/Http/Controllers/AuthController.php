<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function index()
    {
        return view('users.login');
    }

    public function auth(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            return redirect()
                ->route('dashboard')
                ->with('success', 'Selamat Datang, ' . Auth::user()->name);
        }

        return back()
            ->withInput()
            ->withErrors([
                'email' => 'Email atau password tidak valid',
            ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Anda telah keluar aplikasi');
    }
}