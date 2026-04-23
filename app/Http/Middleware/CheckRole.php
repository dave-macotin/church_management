<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * Usage in routes:
     *   Route::middleware('role:admin')->group(...)
     *   Route::middleware('role:admin,staff')->group(...)
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check account approval
        if (! $user->is_approved) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Your account is awaiting approval from an administrator.']);
        }

        // Check role
        if (! in_array($user->role, $roles)) {
            abort(403, 'You do not have permission to access this area.');
        }

        return $next($request);
    }
}