<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login(){
        if (auth()->check()) {
            return redirect('/dashboard');
        }
        return view('admin/login');
    }

    public function post_login(Request $request){
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = [
            'user_email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        // Attempt login
        if (Auth::attempt($credentials)) {
            // Login successful
            $request->session()->regenerate(); // Prevent session fixation
            return redirect()->intended('dashboard')->with('success', 'Login successful!');
        }

        // Login failed
        return back()->with('error', 'Invalid email or password.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Logged out successfully.');
    }
}
