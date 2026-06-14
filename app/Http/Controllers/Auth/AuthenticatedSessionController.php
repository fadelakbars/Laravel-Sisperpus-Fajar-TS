<?php

namespace App\Http\Controllers\Auth;

use App\Enums\PeranPengguna;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->intended($this->redirectPath());
        }

        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        if (! Auth::attempt($request->validated(), $request->boolean('ingat_saya'))) {
            return back()
                ->withErrors(['email' => 'Email atau kata sandi tidak valid.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended($this->redirectPath());
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('login');
    }

    private function redirectPath(): string
    {
        return Auth::user()?->peran === PeranPengguna::Admin
            ? route('admin.dashboard')
            : route('anggota.dashboard');
    }
}
