<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // ─── Show Login ────────────────────────────────────────────────────────────

    public function showLogin()
    {
        return view('auth.login');
    }

    // ─── Handle Login ──────────────────────────────────────────────────────────

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return $this->redirectByRole(Auth::user());
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'These credentials do not match our records.']);
    }

    // ─── Show Register ─────────────────────────────────────────────────────────

    public function showRegister()
    {
        return view('auth.register');
    }

    // ─── Handle Register ───────────────────────────────────────────────────────

    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:80'],
            'last_name'  => ['required', 'string', 'max:80'],
            'email'      => ['required', 'email', 'unique:users,email'],
            'password'   => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
            'role'       => ['required', 'in:admin,staff,member'],
        ]);

        // Admins require manual approval; staff and members are approved immediately
        $isApproved = $validated['role'] !== 'admin';

        $user = User::create([
            'first_name'  => $validated['first_name'],
            'last_name'   => $validated['last_name'],
            'name'        => $validated['first_name'] . ' ' . $validated['last_name'],
            'email'       => $validated['email'],
            'password'    => Hash::make($validated['password']),
            'role'        => $validated['role'],
            'is_approved' => $isApproved,
        ]);

        // Ensure a linked member record exists
        $user->ensureMemberLinked();

        // If role is admin, require approval before logging in
        if ($user->role === 'admin') {
            return redirect()->route('login')
                ->with('status', 'Your admin account is pending approval. You will be notified once approved.');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return $this->redirectByRole($user);
    }

    // ─── Logout ────────────────────────────────────────────────────────────────

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // ─── Role-based Redirect ───────────────────────────────────────────────────

    private function redirectByRole(User $user): \Illuminate\Http\RedirectResponse
    {
        return match ($user->role) {
            'admin'  => redirect()->route('admin.dashboard'),
            'staff'  => redirect()->route('staff.dashboard'),
            default  => redirect()->route('member.dashboard'),
        };
    }
}