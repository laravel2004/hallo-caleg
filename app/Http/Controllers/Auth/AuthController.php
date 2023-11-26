<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Service\IndonesiaAreaService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login() {
        return view('pages.auth.login');
    }

    public function loginPost(Request $request)
    {
        try{
            $validateRequest = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
    
            if (Auth::attempt($validateRequest)) {
                $request->session()->regenerate();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login success',
                    'role' => Auth::user()->role
                ], 200);
            } 
            return response()->json([
                'status' => 'error',
                'message' => 'Username or password is incorrect',
            ], 401) ;
        }   
        catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function register() {
        return view('pages.auth.register');
    }

    public function registerPost(Request $request) {
        try{
            $validateRequest = $request->validate([
                'username' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'confirm_password' => 'required|same:password',
                'role' => 'required'
            ]);

            $user = $this->user->create([
                'username' => $validateRequest['username'],
                'email' => $validateRequest['email'],
                'password' => bcrypt($validateRequest['password']),
                'role' => $validateRequest['role'],
            ]);
        }
        catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request) {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return response()->json([
                'status' => 'success',
                'message' => 'Logout success',
            ]);
        }
        catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
