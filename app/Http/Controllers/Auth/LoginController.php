<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        Log::debug('Displaying login form');
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            Log::info('User authenticated', [
                'id' => Auth::id(),
                'ip' => $request->ip()
            ]);

            return $this->authenticated($request, Auth::user());
        }

        Log::warning('Failed login attempt', [
            'email' => $request->email,
            'ip' => $request->ip()
        ]);

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

   protected function authenticated(Request $request, $user)
{
    if ($user->hasRole('admin')) {
        return redirect()->intended(route('admin.dashboard'));
    }

    if ($user->hasRole('author')) {
        return redirect()->intended(route('admin.posts.index'));
    }

    return redirect()->intended('/');
}

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}