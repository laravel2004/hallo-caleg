<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole {
    public function handle(Request $request, Closure $next, $role) {
        if (!$request->user()) {
            return redirect('/auth/login');
        }

        if ($request->user()->role == $role) {
            return $next($request);
        }

        if ($request->user()->role == 0) {
            return redirect('/dashboard/admin')->with('error', 'Unauthorized access.');
        } else {
            return redirect('/dashboard/relawan')->with('error', 'Unauthorized access.');
        }

        return redirect('/')->with('error', 'Unauthorized.');
    }
}
