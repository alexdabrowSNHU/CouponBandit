<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller {
    public function index(){
        // If user is authenticated
        if (Auth::check()) {
            // send em home
            return redirect()->route('home');
        }

        return response()
            ->view('login.login_page')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache');
    }

    public function authenticate(Request $request)
    {
        // First we null check
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Remember me
        $remember = $request->boolean('remember');

        // Actual login attempt. By default the second value in the attempt() method, Laravel
        // expects a bool for remembering user. Nice and easy, really cool feature.
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }
        // If the authentication fails, send user back to login page, and 
        // whatever email they used will still be in the email input field
        return back()
            ->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])
            ->onlyInput('email');
    }

    public function demoLogin(Request $request)
    {
        // We fetch and get the demo user
        $user = \App\Models\User::where('email', 'test@example.com')->first();
        // Making sure user isn't null
        if ($user) {
            // Bypassing attempt and logging in directly with the fetched user
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended(route('login'));
        }

        return back()->withErrors(['email' => 'Demo account not available.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
