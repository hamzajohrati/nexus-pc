<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash};

class AuthController extends Controller
{
    /* ------------  GUEST  ------------- */

    public function showLoginForm()     { return view('pages.login'); }
    public function showRegisterForm()  { return view('pages.register'); }

    public function register(Request $r)
    {
        $r->validate([
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'phone_number' => 'required'
        ]);

        $user = User::create([
            'email'    => $r->email,
            'password' => Hash::make($r->password),
            'phone_number'=>$r->phone_number,
            'role'=>'user'
        ]);

        Auth::login($user);               // auto-login
        return redirect()->intended('/');
    }

    public function login(Request $r)
    {
        $r->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);

        $creds = filter_var($r->email, FILTER_VALIDATE_EMAIL)
            ? ['email' => $r->email,  'password' => $r->password]
            : ['phone' => $r->email,  'password' => $r->password];

        if (Auth::attempt($creds, $r->boolean('remember'))) {
            $r->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors(['login' => 'Credentials not recognised.'])
            ->onlyInput('login');
    }

    /* ------------  AUTH  ------------- */

    public function logout(Request $r)
    {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return redirect('/');
    }
}
