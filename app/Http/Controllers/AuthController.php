<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function index()
    {
        return view('pages.guest.report.home');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        // attempt, pengecekan untuk email dan passsword
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role == 'HEAD_STAFF') {
                return redirect()->route('headstaff.dashboard')->with('success', 'Login sebagai Head Staff!');
            } else if ($user->role == 'STAFF') {
                return redirect()->route('responses.home')->with('success', 'Login sebagai Staff!');
            } else if ($user->role == 'GUEST') {
                return redirect()->route('home')->with('success', 'Login sebagai Guest!');
            }
        }

        return redirect()->back()->with('failed', 'Email atau Password tidak terdaftar!');
    }

    public function register(Request $request)
    {
        // Validasi input Email
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        if (User::where('email', $request->email)->exists()) {
            return redirect()->back()->with('failed', 'Email sudah digunakan!');
        } else {
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'GUEST',
            ]);

            // Login otomatis setelah registrasi
            Auth::login($user);

            return redirect()->route('home')->with('success', 'Registrasi berhasil!');
        }
    }

    public function logout()
    {
        Auth::logout();
        return view('welcome');
    }
}
