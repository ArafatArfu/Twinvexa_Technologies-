<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $adminEmails = config('admin.emails', []);

        $userEmail = strtolower(trim((string) $user->email));

        if (empty($adminEmails) || !in_array($userEmail, $adminEmails, true)) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        return $next($request);
    }
}
