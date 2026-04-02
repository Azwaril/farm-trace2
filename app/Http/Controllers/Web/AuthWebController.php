<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth; 

class AuthWebController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function registerPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'no_hp' => 'required',
            'alamat' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'konsumen',
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat
        ]);

        return redirect('/login')->with('success', 'Register berhasil');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return back()->with('error', 'Email atau password salah');
        }

        session(['token' => $token]);

        return redirect('/dashboard');
    }

    public function logout()
    {
        JWTAuth::setToken(session('token'))->invalidate();

        session()->forget('token');

        return redirect('/login');
    }
}