<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use \Illuminate\Http\RedirectResponse;
use \Illuminate\Contracts\View\View;
class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|string|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password)
        ]);

        $user->assignRole('user');

        return response()->json(compact('user'));
    }

    public function registerUser(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $name = $request->first_name . ' ' . $request->last_name;

        $user = User::create([
            'name' => $name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user->assignRole('user');
        Auth::login($user);

        return redirect('/')->with('success', 'Hesabınız başarıyla oluşturuldu! Hoş geldiniz ' . $request->first_name . '!');
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email','password');

        if(!$token = auth('api')->attempt($credentials)){
            return response()->json(['error'=>'Invalid credentials'],401);
        }

        return response()->json(compact('token'));
    }

    public function me(): JsonResponse
    {
        return response()->json(auth('api')->user());
    }

    public function showLoginForm(): Factory |View
    {
        return view('auth.login');
    }

    public function showRegisterForm(): Factory |View
    {
        return view('auth.register');
    }

    public function loginUser(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Giriş başarılı!');
        }

        return back()->withErrors([
            'email' => 'Email veya şifre yanlış.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Başarıyla çıkış yapıldı.');
    }
}
