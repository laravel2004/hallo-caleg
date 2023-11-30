<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Service\IndonesiaAreaService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {

    private User $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function login() {
        return view('pages.auth.login');
    }

    public function loginPost(Request $request) {
        try {
            $validateRequest = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if (Auth::attempt($validateRequest)) {
                $request->session()->regenerate();

                if (Auth::user()->role == 0) {
                    return redirect('/dashboard/admin');
                }

                return redirect('/dashboard/relawan/');
            }

            $userExists = User::where('email', $validateRequest['email'])->exists();

            if (!$userExists) {
                return back()->with('error', 'Akun tidak ditemukan. Buat akun terlebih dahulu!');
            }

            return back()->with('error', 'Email atau password salah!');
        } catch (Exception $e) {
            return back()->with('error', 'Login gagal!');
        }
    }

    public function register() {
        return view('pages.auth.register');
    }

    public function registerPost(Request $request) {
        try {
            $validateRequest = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
                'confirm_password' => 'required|same:password',
                'role' => 'required'
            ]);

            if ($validateRequest->fails()) {
                return back()->withErrors($validateRequest)->withInput();
            }

            $this->user->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            return redirect('/auth/login')->with('success', 'Pendaftaran akun berhasil! Silakan masuk.');
        } catch (Exception $e) {
            return back()->with('error', 'Pendaftaran akun gagal!');
        }
    }

    public function logout(Request $request) {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/auth/login')->with('success', 'Logout Berhasil');
        } catch (Exception $e) {
            return back()->with('error', 'Logout failed');
        }
    }
}
