<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — Grace Church CMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: '#c8860a',
                        'gold-mid': '#e6a020',
                        'gold-muted': '#9a7a65',
                        cream: '#e8d5c0',
                        main: '#e8d5c0',
                        muted: '#9a7a65',
                        accent: '#c8860a'
                    },
                    fontFamily: {
                        cinzel: ['Cinzel', 'serif']
                    }
                }
            }
        }
    </script>
    <style>
        /* ── Reset & Base ─────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg-deep:      #0e0703;
            --bg-panel:     #1a0f05;
            --bg-card:      #221208;
            --bg-input:     #2A1605;
            --bg-hover:     #2e1a08;
            --border:       rgba(200, 169, 122, 0.18);
            --border-soft:  rgba(200, 169, 122, 0.10);
            --gold-bright:  #EF9F27;
            --gold-mid:     #FAC775;
            --gold-muted:   #c8a97a;
            --cream:        #FAEEDA;
            --accent:       #D85A30;
            --accent-dark:  #BA4A22;
            --accent-glow:  rgba(216, 90, 48, 0.15);
            --green:        #5DCAA5;
            --green-bg:     rgba(29, 158, 117, 0.12);
            --red:          #F0997B;
            --red-bg:       rgba(216, 90, 48, 0.12);
            --blue:         #7BB8E8;
            --blue-bg:      rgba(123, 184, 232, 0.12);
            --purple:       #B89FE8;
            --purple-bg:    rgba(184, 159, 232, 0.12);
            --sidebar-w:    240px;
            --sidebar-collapsed: 64px;
            --topbar-h:     60px;
            --radius:       10px;
            --shadow:       0 2px 12px rgba(0,0,0,0.4);
        }

        [data-theme="light"] {
            --bg-deep:      #f5ede0;
            --bg-panel:     #fdf6ec;
            --bg-card:      #ffffff;
            --bg-input:     #f0e8d8;
            --bg-hover:     #efe0c8;
            --border:       rgba(120, 80, 30, 0.18);
            --border-soft:  rgba(120, 80, 30, 0.10);
            --cream:        #3a1f05;
            --gold-mid:     #7a4a10;
            --gold-muted:   #8a5a20;
            --shadow:       0 2px 12px rgba(0,0,0,0.10);
        }

        html, body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            background: var(--bg-deep);
            color: var(--cream);
            transition: background 0.3s, color 0.3s;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, .logo-name, .topbar-title, .panel-title, .welcome-name {
            font-family: 'Outfit', sans-serif;
        }

        /* ── App Shell ────────────────────────────────────── */
        .app-shell {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* ═══════════════════════════════════════════════════
           SIDEBAR
        ═══════════════════════════════════════════════════ */
        .sidebar {
            width: var(--sidebar-w);
            min-width: var(--sidebar-w);
            background: var(--bg-panel);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            transition: width 0.25s ease, min-width 0.25s ease;
            overflow: hidden;
            z-index: 100;
            flex-shrink: 0;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
            min-width: var(--sidebar-collapsed);
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 18px 16px;
            border-bottom: 1px solid var(--border);
            min-height: var(--topbar-h);
            overflow: hidden;
            flex-shrink: 0;
        }

        .logo-cross {
            position: relative;
            width: 26px;
            height: 26px;
            flex-shrink: 0;
        }
        .cross-v {
            position: absolute; left: 50%; top: 0;
            transform: translateX(-50%);
            width: 6px; height: 26px;
            background: var(--gold-bright); border-radius: 2px;
        }
        .cross-h {
            position: absolute; top: 6px; left: 0;
            width: 26px; height: 6px;
            background: var(--gold-bright); border-radius: 2px;
        }

        .logo-text { overflow: hidden; white-space: nowrap; }
        .logo-name { font-size: 13px; font-weight: 600; color: var(--gold-mid); font-family: Georgia, serif; display: block; }
        .logo-sub  { font-size: 10px; color: var(--gold-muted); display: block; margin-top: 2px; }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 12px 0;
        }

        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

        .nav-section-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--gold-muted);
            padding: 10px 20px 4px;
            white-space: nowrap;
            overflow: hidden;
            transition: opacity 0.2s;
        }

        .sidebar.collapsed .nav-section-label { opacity: 0; }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            color: var(--gold-muted);
            text-decoration: none;
            font-size: 13px;
            border-radius: 8px;
            margin: 1px 8px;
            white-space: nowrap;
            transition: background 0.15s, color 0.15s;
            position: relative;
            overflow: hidden;
        }

        .nav-item:hover { 
            background: var(--bg-hover); 
            color: var(--gold-mid); 
            padding-left: 20px;
        }

        .nav-item.active {
            background: linear-gradient(90deg, var(--accent-glow) 0%, transparent 100%);
            color: var(--gold-bright);
            border-left: 3px solid var(--accent);
            border-radius: 0 8px 8px 0;
            margin-left: 0;
        }

        .nav-item .nav-icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-item .nav-icon svg { width: 16px; height: 16px; }

        .nav-label { overflow: hidden; transition: opacity 0.2s; }
        .sidebar.collapsed .nav-label { opacity: 0; }

        .nav-badge {
            margin-left: auto;
            background: var(--accent);
            color: #fff;
            font-size: 10px;
            padding: 1px 6px;
            border-radius: 99px;
            flex-shrink: 0;
            transition: opacity 0.2s;
        }

        .sidebar.collapsed .nav-badge { opacity: 0; }

        .sidebar-footer {
            border-top: 1px solid var(--border);
            padding: 12px 8px;
            flex-shrink: 0;
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px;
            border-radius: 8px;
            overflow: hidden;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--bg-hover) 0%, var(--bg-card) 100%);
            border: 1px solid var(--border);
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: var(--gold-mid);
            flex-shrink: 0;
            font-family: 'Outfit', sans-serif;
            overflow: hidden;
            box-shadow: inset 0 0 8px rgba(0,0,0,0.2);
        }

        .user-avatar.has-image {
            color: transparent;
            border-color: var(--gold-muted);
        }

        .user-info { overflow: hidden; white-space: nowrap; transition: opacity 0.2s; }
        .user-name { font-size: 12px; font-weight: 600; color: var(--gold-mid); display: block; }
        .user-role { font-size: 10px; color: var(--gold-muted); display: block; }
        .sidebar.collapsed .user-info { opacity: 0; }

        /* ═══════════════════════════════════════════════════
           MAIN AREA
        ═══════════════════════════════════════════════════ */
        .main-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            min-width: 0;
        }

        .topbar {
            height: var(--topbar-h);
            background: rgba(26, 15, 5, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 12px;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .topbar-toggle {
            width: 34px; height: 34px;
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold-muted);
            transition: background 0.15s, color 0.15s;
            flex-shrink: 0;
        }

        .topbar-toggle:hover { background: var(--bg-hover); color: var(--gold-mid); }

        .topbar-title {
            font-family: Georgia, serif;
            font-size: 16px;
            color: var(--gold-mid);
            font-weight: 400;
        }

        .topbar-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .topbar-btn {
            width: 34px; height: 34px;
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold-muted);
            transition: background 0.15s, color 0.15s;
            position: relative;
        }

        .topbar-btn:hover { background: var(--bg-hover); color: var(--gold-mid); }

        .theme-toggle-btn {
            width: 34px; height: 34px;
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold-muted);
            transition: background 0.15s, color 0.15s;
        }
        .theme-toggle-btn:hover { background: var(--bg-hover); color: var(--gold-mid); }

        .page-content {
            flex: 1;
            overflow-y: auto;
            padding: 28px 28px 40px;
        }

        .page-content::-webkit-scrollbar { width: 6px; }
        .page-content::-webkit-scrollbar-track { background: transparent; }
        .page-content::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

        /* Shared Components */
        .card, .panel {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
        }

        .panel-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-soft);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .panel-title {
            font-family: Georgia, serif;
            font-size: 14px;
            color: var(--gold-mid);
            font-weight: 400;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .panel-title svg { width: 14px; height: 14px; color: var(--gold-bright); }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            background: var(--bg-input);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 14px;
            color: var(--cream);
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
        }
        .form-input:focus, .form-select:focus, .form-textarea:focus { 
            border-color: var(--gold-bright); 
            background: var(--bg-card);
            box-shadow: 0 0 0 3px rgba(239, 159, 39, 0.1);
        }

        .search-wrap { position: relative; display: flex; align-items: center; }
        .search-wrap svg { position: absolute; left: 12px; width: 16px; height: 16px; color: var(--gold-muted); pointer-events: none; }
        .search-wrap .form-input { padding-left: 38px; }

        /* ── Buttons ────────────────────────────────────── */
        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            user-select: none;
            white-space: nowrap;
        }

        .btn:active { transform: scale(0.98); }
        .btn:disabled { opacity: 0.5; cursor: not-allowed; }

        .btn-gold { background: var(--gold-bright); color: #000; box-shadow: 0 4px 12px rgba(239, 159, 39, 0.2); }
        .btn-gold:hover { background: var(--gold-mid); transform: translateY(-1px); box-shadow: 0 6px 16px rgba(239, 159, 39, 0.3); }

        .btn-secondary { background: var(--bg-hover); color: var(--cream); border: 1px solid var(--border); }
        .btn-secondary:hover { background: var(--bg-card); border-color: var(--gold-muted); }

        .btn-danger { background: var(--red-bg); color: var(--red); border: 1px solid rgba(240, 153, 123, 0.2); }
        .btn-danger:hover { background: var(--red); color: #fff; }

        .btn-ghost { background: transparent; color: var(--gold-muted); border: 1px solid var(--border); }
        .btn-ghost:hover { background: var(--bg-hover); color: var(--gold-mid); }

        .btn-outline-gold { background: transparent; color: var(--gold-bright); border: 1px solid var(--gold-bright); }
        .btn-outline-gold:hover { background: var(--gold-bright); color: #000; }

        .btn-sm { padding: 6px 12px; font-size: 12px; border-radius: 6px; }
        .btn-xs { padding: 4px 8px; font-size: 11px; border-radius: 4px; }

        /* ── Badges ─────────────────────────────────────── */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 10px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .badge-green { background: var(--green-bg); color: var(--green); border: 1px solid rgba(93, 202, 165, 0.2); }
        .badge-amber { background: rgba(239, 159, 39, 0.12); color: var(--gold-bright); border: 1px solid rgba(239, 159, 39, 0.2); }
        .badge-red   { background: var(--red-bg); color: var(--red); border: 1px solid rgba(240, 153, 123, 0.2); }
        .badge-blue  { background: var(--blue-bg); color: var(--blue); border: 1px solid rgba(123, 184, 232, 0.2); }
        .badge-muted { background: var(--bg-hover); color: var(--gold-muted); border: 1px solid var(--border); }

        /* ── Data Tables ────────────────────────────────── */
        .data-table-container { border-radius: var(--radius); overflow: hidden; background: var(--bg-card); }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { 
            background: rgba(0,0,0,0.2); 
            padding: 14px 20px; 
            font-size: 11px; 
            text-transform: uppercase; 
            letter-spacing: 0.1em; 
            color: var(--gold-muted);
            border-bottom: 1px solid var(--border);
        }
        td { 
            padding: 14px 20px; 
            font-size: 14px; 
            border-bottom: 1px solid var(--border-soft);
            transition: background 0.1s;
        }
        tr:hover td { background: var(--bg-hover); }
        tr:last-child td { border-bottom: none; }

        .empty-state {
            text-align: center;
            padding: 48px 24px;
            color: var(--gold-muted);
        }
        .empty-state svg {
            width: 48px; height: 48px;
            margin: 0 auto 16px;
            opacity: 0.3;
        }
        .empty-state h4 { font-family: Georgia, serif; font-size: 18px; color: var(--gold-mid); margin-bottom: 8px; }
        .empty-state p { font-size: 14px; max-width: 400px; margin: 0 auto; line-height: 1.5; }

        @yield('extra_css')
    </style>
</head>
<body>

<div class="app-shell">
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <div class="logo-cross">
                <div class="cross-v"></div>
                <div class="cross-h"></div>
            </div>
            <div class="logo-text">
                <span class="logo-name">{{ App\Models\Setting::get('church_name', 'Grace Church') }}</span>
                <span class="logo-sub">{{ App\Models\Setting::get('church_motto', 'Management System') }}</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Overview</div>
            <a href="{{ route('member.dashboard') }}" class="nav-item {{ request()->routeIs('member.dashboard') ? 'active' : '' }}">
                <span class="nav-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </span>
                <span class="nav-label">Dashboard</span>
            </a>

            <div class="nav-section-label">Ministry</div>
            <a href="{{ route('member.profile') }}" class="nav-item {{ request()->routeIs('member.profile') ? 'active' : '' }}">
                <span class="nav-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </span>
                <span class="nav-label">My Profile</span>
            </a>

            <a href="{{ route('member.attendance') }}" class="nav-item {{ request()->routeIs('member.attendance') ? 'active' : '' }}">
                <span class="nav-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </span>
                <span class="nav-label">Attendance</span>
            </a>

            <a href="{{ route('member.events') }}" class="nav-item {{ request()->routeIs('member.events') ? 'active' : '' }}">
                <span class="nav-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"/>
                    </svg>
                </span>
                <span class="nav-label">Events</span>
            </a>

            <a href="{{ route('member.groups') }}" class="nav-item {{ request()->routeIs('member.groups') ? 'active' : '' }}">
                <span class="nav-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </span>
                <span class="nav-label">My Groups</span>
            </a>

            <a href="{{ route('member.family') }}" class="nav-item {{ request()->routeIs('member.family') ? 'active' : '' }}">
                <span class="nav-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M4 10v9a1 1 0 001 1h4v-5h4v5h4a1 1 0 001-1V10"/>
                    </svg>
                </span>
                <span class="nav-label">Family</span>
            </a>

            <a href="{{ route('member.children.index') }}" class="nav-item {{ request()->routeIs('member.children.*') ? 'active' : '' }}">
                <span class="nav-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </span>
                <span class="nav-label">My Children</span>
            </a>

            <a href="{{ route('sermons.index') }}" class="nav-item {{ request()->routeIs('sermons.*') ? 'active' : '' }}">
                <span class="nav-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </span>
                <span class="nav-label">Sermon Library</span>
            </a>

            <a href="{{ route('member.volunteering.index') }}" class="nav-item {{ request()->routeIs('member.volunteering.*') ? 'active' : '' }}">
                <span class="nav-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </span>
                <span class="nav-label">Volunteering</span>
            </a>

            <div class="nav-section-label">Giving</div>
            <a href="{{ route('member.donations') }}" class="nav-item {{ request()->routeIs('member.donations') ? 'active' : '' }}">
                <span class="nav-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </span>
                <span class="nav-label">My Donations</span>
            </a>



            <a href="{{ route('messages.index') }}" class="nav-item {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                <span class="nav-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                    </svg>
                </span>
                <span class="nav-label">Messages</span>
                @php $unread = \App\Models\Message::where('receiver_id', auth()->id())->whereNull('read_at')->count(); @endphp
                @if($unread > 0)
                    <span class="nav-badge">{{ $unread }}</span>
                @endif
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-card">
                @php 
                    $profilePic = auth()->user()->member?->profile_picture;
                @endphp
                <div class="user-avatar {{ $profilePic ? 'has-image' : '' }}" 
                     style="{{ $profilePic ? 'background-image:url('.asset('storage/'.$profilePic).');' : '' }}">
                    @if(!$profilePic)
                        {{ strtoupper(substr(auth()->user()->name ?? 'M', 0, 1)) }}
                    @endif
                </div>
                <div class="user-info">
                    <span class="user-name">{{ auth()->user()->name ?? 'Member' }}</span>
                    <span class="user-role">Church Member</span>
                </div>
            </div>
        </div>
    </aside>

    <div class="main-area">
        <header class="topbar">
            <button class="topbar-toggle" id="sidebarToggle">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <span class="topbar-title">@yield('page_title', 'Dashboard')</span>
            <div class="topbar-right">
                <button class="topbar-btn"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg></button>
                <button class="theme-toggle-btn" id="themeToggle">
                    <svg id="iconSun" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m8.66-9H21M3 12H2m15.07-6.07l-.71.71M7.64 16.36l-.71.71M18.36 16.36l-.71-.71M6.34 7.64l-.71-.71M12 7a5 5 0 100 10A5 5 0 0012 7z"/></svg>
                    <svg id="iconMoon" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </button>
                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="topbar-btn"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg></button></form>
            </div>
        </header>

        <main class="page-content">
            @if(session('success'))
                <div style="background:var(--green-bg); color:var(--green); border:1px solid rgba(93,202,165,0.2); padding:12px 18px; border-radius:8px; margin-bottom:20px; font-size:14px;">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background:var(--red-bg); color:var(--red); border:1px solid rgba(240,153,123,0.2); padding:12px 18px; border-radius:8px; margin-bottom:20px; font-size:14px;">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const STORAGE_KEY = 'grace_sidebar_collapsed';

    function applySidebarState(collapsed) {
        sidebar.classList.toggle('collapsed', collapsed);
        localStorage.setItem(STORAGE_KEY, collapsed ? '1' : '0');
    }

    applySidebarState(localStorage.getItem(STORAGE_KEY) === '1');
    sidebarToggle.addEventListener('click', () => applySidebarState(!sidebar.classList.contains('collapsed')));

    const html = document.documentElement;
    const themeBtn = document.getElementById('themeToggle');
    const iconSun = document.getElementById('iconSun');
    const iconMoon = document.getElementById('iconMoon');
    const THEME_KEY = 'grace_theme';

    function applyTheme(theme) {
        html.setAttribute('data-theme', theme);
        localStorage.setItem(THEME_KEY, theme);
        const isDark = theme === 'dark';
        iconSun.style.display = isDark ? 'none' : 'block';
        iconMoon.style.display = isDark ? 'block' : 'none';
    }

    applyTheme(localStorage.getItem(THEME_KEY) || 'dark');
    themeBtn.addEventListener('click', () => applyTheme(html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark'));
</script>
@yield('extra_js')
</body>
</html>
