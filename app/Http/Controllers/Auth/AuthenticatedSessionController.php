<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = auth()->user();

        // Redirect berdasarkan role
        if ($user->role === 'pimpinan') {
            return redirect()->route('pimpinan.dashboard');
        }

        if ($user->role === 'admin_absensi') {
            return redirect()->route('absensi.admin.dashboard');
        }

        if ($user->role === 'admin_peminjaman') {
            return redirect()->route('peminjaman.admin.dashboard');
        }

        if ($user->role === 'magang') {
            return redirect()->route('absensi.magang.dashboard');
        }

        if ($user->role === 'user_peminjaman') {
            return redirect()->route('dashboard');
        }

        if ($user->role === 'admin_barang') {
            return redirect()->route('barang.admin.dashboard');
        }

        if ($user->role === 'pegawai') {
            return redirect()->route('pegawai.dashboard');
        }

        if ($user->role === 'resepsionis') {
            return redirect()->route('resepsionis.dashboard');
        }

        // Default fallback
        return redirect()->route('dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
