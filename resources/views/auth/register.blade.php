<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — Grace Church CMS</title>
    <style>
        /* ── Reset & Base ─────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            min-height: 100vh;
            display: flex;
            background: #0e0703;
            color: #FAEEDA;
        }

        /* ── Layout ───────────────────────────────────────── */
        .auth-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            width: 100%;
            min-height: 100vh;
        }

        /* ── Left — Image Panel ───────────────────────────── */
        .image-panel {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
        }

        .image-panel img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to bottom,
                rgba(14, 7, 3, 0.15) 0%,
                rgba(14, 7, 3, 0.10) 50%,
                rgba(14, 7, 3, 0.72) 85%,
                rgba(14, 7, 3, 0.90) 100%
            );
        }

        .image-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 36px 40px;
        }

        .verse-text {
            font-size: 18px;
            font-style: italic;
            font-weight: 400;
            color: #FAC775;
            line-height: 1.6;
            margin-bottom: 8px;
            text-shadow: 0 1px 4px rgba(0,0,0,0.6);
        }

        .verse-ref {
            font-size: 13px;
            font-style: normal;
            color: #c8a97a;
            letter-spacing: 0.05em;
        }

        /* ── Right — Form Panel ───────────────────────────── */
        .form-panel {
            background: #1a0f05;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 52px;
            border-left: 1px solid rgba(200, 169, 122, 0.18);
            overflow-y: auto;
        }

        /* ── Logo ─────────────────────────────────────────── */
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 32px;
        }

        .logo-cross {
            position: relative;
            width: 28px;
            height: 28px;
            flex-shrink: 0;
        }

        .cross-v {
            position: absolute;
            left: 50%;
            top: 0;
            transform: translateX(-50%);
            width: 6px;
            height: 28px;
            background: #EF9F27;
            border-radius: 2px;
        }

        .cross-h {
            position: absolute;
            top: 7px;
            left: 0;
            width: 28px;
            height: 6px;
            background: #EF9F27;
            border-radius: 2px;
        }

        .logo-text { font-family: Georgia, serif; }
        .logo-name { font-size: 15px; font-weight: 400; color: #FAC775; display: block; }
        .logo-sub  { font-size: 11px; color: #c8a97a; display: block; margin-top: 2px; font-family: Arial, sans-serif; }

        /* ── Headings ─────────────────────────────────────── */
        .form-title {
            font-size: 28px;
            font-weight: 400;
            color: #FAEEDA;
            margin-bottom: 6px;
        }

        .form-subtitle {
            font-size: 14px;
            color: #c8a97a;
            font-family: Arial, sans-serif;
            margin-bottom: 28px;
            font-style: italic;
        }

        /* ── Alerts ───────────────────────────────────────── */
        .alert-error {
            background: rgba(216, 90, 48, 0.15);
            border: 1px solid rgba(216, 90, 48, 0.4);
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #F0997B;
        }

        /* ── Form Fields ──────────────────────────────────── */
        .field-group { margin-bottom: 16px; }

        .field-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .field-label {
            display: block;
            font-size: 11px;
            color: #c8a97a;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 7px;
            font-family: Arial, sans-serif;
        }

        .field-input {
            width: 100%;
            height: 44px;
            padding: 0 14px;
            background: #2A1605;
            border: 1px solid rgba(200, 169, 122, 0.30);
            border-radius: 8px;
            color: #FAEEDA;
            font-size: 14px;
            font-family: Arial, sans-serif;
            outline: none;
            transition: border-color 0.2s;
        }

        .field-input:focus { border-color: #EF9F27; }
        .field-input::placeholder { color: rgba(200, 169, 122, 0.35); }
        .field-input.is-invalid { border-color: #D85A30; }

        .field-error {
            font-size: 12px;
            color: #F0997B;
            margin-top: 5px;
            font-family: Arial, sans-serif;
        }

        /* ── Role Selector ────────────────────────────────── */
        .role-label {
            display: block;
            font-size: 11px;
            color: #c8a97a;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 10px;
            font-family: Arial, sans-serif;
        }

        .role-options {
            display: flex;
            gap: 10px;
            margin-bottom: 22px;
            flex-wrap: wrap;
        }

        .role-option { position: relative; }

        .role-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .role-option label {
            display: block;
            padding: 8px 18px;
            border-radius: 99px;
            border: 1px solid rgba(200, 169, 122, 0.30);
            color: #c8a97a;
            font-size: 13px;
            font-family: Arial, sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            user-select: none;
        }

        .role-option input:checked + label {
            background: rgba(216, 90, 48, 0.18);
            border-color: #D85A30;
            color: #EF9F27;
        }

        .role-option label:hover { border-color: #c8a97a; color: #FAC775; }

        .role-hint {
            font-size: 11px;
            color: rgba(200, 169, 122, 0.5);
            font-family: Arial, sans-serif;
            margin-bottom: 20px;
            margin-top: -14px;
        }

        /* ── Terms ────────────────────────────────────────── */
        .terms-row {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 22px;
        }

        .terms-row input[type="checkbox"] {
            accent-color: #D85A30;
            width: 15px;
            height: 15px;
            margin-top: 2px;
            cursor: pointer;
            flex-shrink: 0;
        }

        .terms-row label {
            font-size: 12px;
            color: #c8a97a;
            font-family: Arial, sans-serif;
            line-height: 1.5;
        }

        .terms-row a { color: #EF9F27; text-decoration: none; }

        /* ── Buttons ──────────────────────────────────────── */
        .btn-primary {
            width: 100%;
            height: 46px;
            background: #D85A30;
            border: none;
            border-radius: 8px;
            color: #FAEEDA;
            font-size: 14px;
            font-weight: 500;
            font-family: Arial, sans-serif;
            cursor: pointer;
            letter-spacing: 0.04em;
            transition: background 0.2s;
            margin-bottom: 24px;
        }

        .btn-primary:hover { background: #BA4A22; }

        /* ── Footer link ──────────────────────────────────── */
        .auth-footer {
            text-align: center;
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #c8a97a;
        }

        .auth-footer a { color: #EF9F27; text-decoration: none; }
        .auth-footer a:hover { text-decoration: underline; }

        /* ── Responsive ───────────────────────────────────── */
        @media (max-width: 768px) {
            .auth-wrapper { grid-template-columns: 1fr; }
            .image-panel { min-height: 220px; }
            .form-panel { padding: 32px 24px; }
            .field-row { grid-template-columns: 1fr; gap: 0; }
        }
    </style>
</head>
<body>

<div class="auth-wrapper">

    {{-- ── Left: Image Panel ──────────────────────────── --}}
    <div class="image-panel">
        <img
            src="{{ asset('images/auth-banner.jpg') }}"
            alt="Three crosses at sunset"
        >
        <div class="image-overlay"></div>
        <div class="image-content">
            <p class="verse-text">
                "You armed me with strength for battle; you humbled my adversaries before me."
            </p>
            <span class="verse-ref">— Psalm 18:39</span>
        </div>
    </div>

    {{-- ── Right: Register Form ────────────────────────── --}}
    <div class="form-panel">

        <div class="logo">
            <div class="logo-cross">
                <div class="cross-v"></div>
                <div class="cross-h"></div>
            </div>
            <div class="logo-text">
                <span class="logo-name">Grace Church CMS</span>
                <span class="logo-sub">Church Management System</span>
            </div>
        </div>

        <h1 class="form-title">Join the ministry</h1>
        <p class="form-subtitle">Create your account to get started</p>

        @if ($errors->any())
            <div class="alert-error">
                <strong>Please fix the following:</strong><br>
                <ul style="margin-top:6px; padding-left:16px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}">
            @csrf

            {{-- Name row --}}
            <div class="field-row">
                <div class="field-group">
                    <label class="field-label" for="first_name">First name</label>
                    <input
                        id="first_name"
                        type="text"
                        name="first_name"
                        class="field-input @error('first_name') is-invalid @enderror"
                        value="{{ old('first_name') }}"
                        placeholder="Juan"
                        required
                    >
                    @error('first_name')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="field-group">
                    <label class="field-label" for="last_name">Last name</label>
                    <input
                        id="last_name"
                        type="text"
                        name="last_name"
                        class="field-input @error('last_name') is-invalid @enderror"
                        value="{{ old('last_name') }}"
                        placeholder="dela Cruz"
                        required
                    >
                    @error('last_name')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Email --}}
            <div class="field-group">
                <label class="field-label" for="email">Email address</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    class="field-input @error('email') is-invalid @enderror"
                    value="{{ old('email') }}"
                    placeholder="you@church.org"
                    autocomplete="email"
                    required
                >
                @error('email')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Password row --}}
            <div class="field-row">
                <div class="field-group">
                    <label class="field-label" for="password">Password</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="field-input @error('password') is-invalid @enderror"
                        placeholder="Min. 8 characters"
                        autocomplete="new-password"
                        required
                    >
                    @error('password')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="field-group">
                    <label class="field-label" for="password_confirmation">Confirm password</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        class="field-input"
                        placeholder="Re-enter password"
                        autocomplete="new-password"
                        required
                    >
                </div>
            </div>

            {{-- Role --}}
            <span class="role-label">Select your role</span>
            <div class="role-options">

                <div class="role-option">
                    <input type="radio" id="role_admin" name="role" value="admin"
                        {{ old('role') === 'admin' ? 'checked' : '' }}>
                    <label for="role_admin">Admin</label>
                </div>

                <div class="role-option">
                    <input type="radio" id="role_staff" name="role" value="staff"
                        {{ old('role', 'member') === 'staff' ? 'checked' : '' }}>
                    <label for="role_staff">Staff</label>
                </div>

                <div class="role-option">
                    <input type="radio" id="role_member" name="role" value="member"
                        {{ old('role', 'member') === 'member' ? 'checked' : '' }}>
                    <label for="role_member">Member</label>
                </div>

            </div>
            <p class="role-hint">Admin accounts require approval before first login.</p>

            @error('role')
                <span class="field-error" style="display:block; margin-top:-14px; margin-bottom:14px;">{{ $message }}</span>
            @enderror

            {{-- Terms --}}
            <div class="terms-row">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">
                    I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a> of Grace Church CMS.
                </label>
            </div>

            <button type="submit" class="btn-primary">Create account</button>

        </form>

        <p class="auth-footer">
            Already have an account? <a href="{{ route('login') }}">Sign in</a>
        </p>

    </div>
</div>

</body>
</html>
