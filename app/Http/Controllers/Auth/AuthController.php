<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Service\IndonesiaAreaService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            return back()->with('error', 'email or password is wrong!');
        } catch (Exception $e) {
            return back()->with('error', 'Login gagal!');
        }
    }

    public function register() {
        return view('pages.auth.register');
    }

    public function registerPost(Request $request) {
        try {
            $validateRequest = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'confirm_password' => 'required|same:password',
                'role' => 'required'
            ]);

            $this->user->insert([
                'name' => $validateRequest['name'],
                'email' => $validateRequest['email'],
                'password' => bcrypt($validateRequest['password']),
                'role' => $validateRequest['role'],
            ]);

            return redirect('/auth/login')->with('success', 'Pendaftaran akun berhasil!');
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
