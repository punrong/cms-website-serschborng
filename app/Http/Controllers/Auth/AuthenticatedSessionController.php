<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
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

    public function getMenuSideBarPermission()
    {
        return ['can' => [
            'posts' => Auth::user()->can('post list'),
            'permissions' => Auth::user()->can('permission list'),
            'roles' => Auth::user()->can('role list'),
            'users' => Auth::user()->can('user list'),
            'categories' => Auth::user()->can('category list'),
            'mentors' => Auth::user()->can('mentor list'),
            'page_settings' => Auth::user()->can('page-settings list'),
            'join_our_networks' => Auth::user()->can('join-our-networks list'),
            'appointments' => Auth::user()->can('appointment list'),
        ]];
    }
}
