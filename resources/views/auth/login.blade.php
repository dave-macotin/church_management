<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — Grace Church CMS</title>
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

        /* Dark gradient overlay so text is readable */
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
            padding: 56px 52px;
            border-left: 1px solid rgba(200, 169, 122, 0.18);
        }

        /* ── Logo ─────────────────────────────────────────── */
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
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
            margin-bottom: 32px;
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

        .alert-success {
            background: rgba(29, 158, 117, 0.15);
            border: 1px solid rgba(29, 158, 117, 0.4);
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #5DCAA5;
        }

        /* ── Form Fields ──────────────────────────────────── */
        .field-group { margin-bottom: 18px; }

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

        .field-input:focus {
            border-color: #EF9F27;
        }

        .field-input::placeholder { color: rgba(200, 169, 122, 0.35); }

        .field-input.is-invalid { border-color: #D85A30; }

        .field-error {
            font-size: 12px;
            color: #F0997B;
            margin-top: 5px;
            font-family: Arial, sans-serif;
        }

        /* ── Forgot Link ──────────────────────────────────── */
        .forgot-row {
            display: flex;
            justify-content: flex-end;
            margin-top: -10px;
            margin-bottom: 22px;
        }

        .forgot-row a {
            font-size: 12px;
            color: #EF9F27;
            text-decoration: none;
            font-family: Arial, sans-serif;
        }

        .forgot-row a:hover { text-decoration: underline; }

        /* ── Remember Me ──────────────────────────────────── */
        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 22px;
        }

        .remember-row input[type="checkbox"] {
            accent-color: #D85A30;
            width: 15px;
            height: 15px;
            cursor: pointer;
        }

        .remember-row label {
            font-size: 13px;
            color: #c8a97a;
            font-family: Arial, sans-serif;
            cursor: pointer;
        }

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
            margin-bottom: 16px;
        }

        .btn-primary:hover { background: #BA4A22; }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .divider-line { flex: 1; height: 1px; background: rgba(200, 169, 122, 0.18); }
        .divider-text { font-size: 11px; color: rgba(200, 169, 122, 0.5); font-family: Arial, sans-serif; }

        .btn-google {
            width: 100%;
            height: 44px;
            background: transparent;
            border: 1px solid rgba(200, 169, 122, 0.30);
            border-radius: 8px;
            color: #c8a97a;
            font-size: 13px;
            font-family: Arial, sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: border-color 0.2s, color 0.2s;
            margin-bottom: 28px;
            text-decoration: none;
        }

        .btn-google:hover { border-color: #c8a97a; color: #FAC775; }

        .google-icon {
            width: 16px;
            height: 16px;
            display: inline-block;
        }

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
            .image-panel { min-height: 240px; }
            .form-panel { padding: 36px 28px; }
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

    {{-- ── Right: Login Form ───────────────────────────── --}}
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

        <h1 class="form-title">Welcome back</h1>
        <p class="form-subtitle">Sign in to continue to your ministry</p>

        {{-- Status message (e.g. after register pending approval) --}}
        @if (session('status'))
            <div class="alert-success">{{ session('status') }}</div>
        @endif

        {{-- General error --}}
        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

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

            <div class="field-group">
                <label class="field-label" for="password">Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="field-input @error('password') is-invalid @enderror"
                    placeholder="••••••••"
                    autocomplete="current-password"
                    required
                >
                @error('password')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="forgot-row">
                <a href="#">Forgot password?</a>
            </div>

            <div class="remember-row">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Keep me signed in</label>
            </div>

            <button type="submit" class="btn-primary">Sign in</button>

        </form>

        <div class="divider">
            <span class="divider-line"></span>
            <span class="divider-text">or</span>
            <span class="divider-line"></span>
        </div>


        <p class="auth-footer">
            Don't have an account? <a href="{{ route('register') }}">Create one</a>
        </p>

    </div>
</div>

</body>
</html>
