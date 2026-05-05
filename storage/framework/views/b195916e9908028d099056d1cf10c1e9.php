<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', App\Models\Setting::get('church_name', 'Grace Church') . ' — CMS'); ?></title>
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

        /* SIDEBAR */
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

        /* MAIN AREA */
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

        /* ── Forms ──────────────────────────────────────── */
        .form-group { margin-bottom: 20px; }
        .form-label { 
            display: block; 
            font-size: 12px; 
            font-weight: 600; 
            color: var(--gold-muted); 
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
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
    </style>
    <?php echo $__env->yieldContent('extra_css'); ?>
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
                <span class="logo-name"><?php echo e(App\Models\Setting::get('church_name', 'Grace Church')); ?></span>
                <span class="logo-sub">Admin Portal</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Overview</div>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                <span class="nav-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </span>
                <span class="nav-label">Dashboard</span>
            </a>

            <div class="nav-section-label">People</div>
            <a href="<?php echo e(route('admin.members.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.members.*') ? 'active' : ''); ?>">
                <span class="nav-icon"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg></span>
                <span class="nav-label">Members</span>
            </a>
            <a href="<?php echo e(route('admin.families.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.families.*') ? 'active' : ''); ?>">
                <span class="nav-icon"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg></span>
                <span class="nav-label">Families</span>
            </a>
            <a href="<?php echo e(route('admin.groups.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.groups.*') ? 'active' : ''); ?>">
                <span class="nav-icon"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg></span>
                <span class="nav-label">Groups</span>
            </a>

            <div class="nav-section-label">Ministry</div>
            <a href="<?php echo e(route('admin.events.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.events.*') ? 'active' : ''); ?>">
                <span class="nav-icon"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg></span>
                <span class="nav-label">Events</span>
            </a>
            <a href="<?php echo e(route('admin.attendance.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.attendance.*') ? 'active' : ''); ?>">
                <span class="nav-icon"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></span>
                <span class="nav-label">Attendance</span>
            </a>
            <a href="<?php echo e(route('admin.sermons.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.sermons.*') ? 'active' : ''); ?>">
                <span class="nav-icon"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg></span>
                <span class="nav-label">Sermons</span>
            </a>
            <a href="<?php echo e(route('admin.checkin.kiosk')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.checkin.*') ? 'active' : ''); ?>">
                <span class="nav-icon"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg></span>
                <span class="nav-label">Check-In</span>
            </a>
            <a href="<?php echo e(route('admin.volunteering.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.volunteering.*') ? 'active' : ''); ?>">
                <span class="nav-icon"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-1.82.756l1.233 5.378c.117.513-.42.921-.861.642L12 17.653a.563.563 0 00-.733 0l-4.743 2.808c-.44.28-.978-.13-.861-.642L6.896 14.44a.563.563 0 00-.181-.756L2.51 10.081c-.38-.325-.178-.948.321-.988l5.518-.442a.563.563 0 00.475-.345L10.96 3.5z"/></svg></span>
                <span class="nav-label">Volunteering</span>
            </a>

            <div class="nav-section-label">Finance</div>
            <a href="<?php echo e(route('admin.donations.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.donations.*') ? 'active' : ''); ?>">
                <span class="nav-icon"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></span>
                <span class="nav-label">Donations</span>
            </a>
            <a href="<?php echo e(route('admin.expenses.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.expenses.*') ? 'active' : ''); ?>">
                <span class="nav-icon"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg></span>
                <span class="nav-label">Expenses</span>
            </a>
            <a href="<?php echo e(route('admin.assets.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.assets.*') ? 'active' : ''); ?>">
                <span class="nav-icon"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg></span>
                <span class="nav-label">Assets</span>
            </a>

            <div class="nav-section-label">Admin</div>
            <a href="<?php echo e(route('admin.users.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>">
                <span class="nav-icon"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg></span>
                <span class="nav-label">Users</span>
            </a>
            <a href="<?php echo e(route('admin.settings')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.settings') ? 'active' : ''); ?>">
                <span class="nav-icon"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg></span>
                <span class="nav-label">Settings</span>
            </a>

            <div class="nav-section-label">Account</div>
            <a href="<?php echo e(route('admin.profile.edit')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.profile.*') ? 'active' : ''); ?>">
                <span class="nav-icon"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></span>
                <span class="nav-label">Profile</span>
            </a>
            <a href="<?php echo e(route('messages.index')); ?>" class="nav-item <?php echo e(request()->routeIs('messages.*') ? 'active' : ''); ?>">
                <span class="nav-icon"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg></span>
                <span class="nav-label">Messages</span>
                <?php $unread = \App\Models\Message::where('receiver_id', auth()->id())->whereNull('read_at')->count(); ?>
                <?php if($unread > 0): ?>
                    <span class="nav-badge"><?php echo e($unread); ?></span>
                <?php endif; ?>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-card">
                <?php 
                    $profilePic = auth()->user()->member?->profile_picture;
                ?>
                <div class="user-avatar <?php echo e($profilePic ? 'has-image' : ''); ?>" 
                     style="<?php echo e($profilePic ? 'background-image:url('.asset('storage/'.$profilePic).');' : ''); ?>">
                    <?php if(!$profilePic): ?>
                        <?php echo e(strtoupper(substr(auth()->user()->name ?? 'A', 0, 1))); ?>

                    <?php endif; ?>
                </div>
                <div class="user-info">
                    <span class="user-name"><?php echo e(auth()->user()->name ?? 'Admin'); ?></span>
                    <span class="user-role">Administrator</span>
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
            <span class="topbar-title"><?php echo $__env->yieldContent('page_title', 'Admin Panel'); ?></span>
            
            <div class="flex-1 max-w-md mx-4 relative hidden md:block">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gold-muted/50" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                    </svg>
                    <input type="text" id="globalSearchInput" placeholder="Quick Search" class="form-input !pl-10 !py-1.5 text-sm" autocomplete="off">
                </div>
                <div id="searchResults" class="absolute left-0 right-0 mt-2 card shadow-2xl z-50 hidden" style="max-height: 400px; overflow-y: auto; border: 1px solid var(--gold); background: var(--bg-card);">
                    
                </div>
            </div>

            <div class="topbar-right">
                <button class="theme-toggle-btn" id="themeToggle">
                    <svg id="iconSun" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m8.66-9H21M3 12H2m15.07-6.07l-.71.71M7.64 16.36l-.71.71M18.36 16.36l-.71-.71M6.34 7.64l-.71-.71M12 7a5 5 0 100 10A5 5 0 0012 7z"/></svg>
                    <svg id="iconMoon" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </button>
                <form method="POST" action="<?php echo e(route('logout')); ?>"><?php echo csrf_field(); ?><button type="submit" class="topbar-btn"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg></button></form>
            </div>
        </header>

        <main class="page-content">
            <?php if(session('success')): ?>
                <div style="background:var(--green-bg); color:var(--green); border:1px solid rgba(93,202,165,0.2); padding:12px 18px; border-radius:8px; margin-bottom:20px; font-size:14px;">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div style="background:var(--red-bg); color:var(--red); border:1px solid rgba(240,153,123,0.2); padding:12px 18px; border-radius:8px; margin-bottom:20px; font-size:14px;">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const STORAGE_KEY = 'grace_sidebar_collapsed_admin';

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

    // Global Search Logic
    const searchInput = document.getElementById('globalSearchInput');
    const searchResults = document.getElementById('searchResults');
    let searchTimeout;

    window.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            searchInput.focus();
        }
    });

    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimeout);
        const query = searchInput.value;
        if (query.length < 2) {
            searchResults.classList.add('hidden');
            return;
        }

        searchTimeout = setTimeout(() => {
            fetch(`<?php echo e(route('admin.search')); ?>?query=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    renderResults(data);
                });
        }, 300);
    });

    function renderResults(data) {
        searchResults.innerHTML = '';
        if (data.length === 0) {
            searchResults.innerHTML = '<div class="p-4 text-sm text-center" style="color:var(--text-muted)">No results found</div>';
        } else {
            data.forEach(item => {
                const div = document.createElement('a');
                div.href = item.url;
                div.className = 'block p-3 border-b border-border hover:bg-hover transition-colors';
                div.innerHTML = `
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium" style="color:var(--gold-mid)">${item.title}</span>
                        <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded" style="background:var(--bg-hover); color:var(--text-muted)">${item.type}</span>
                    </div>
                `;
                searchResults.appendChild(div);
            });
        }
        searchResults.classList.remove('hidden');
    }

    // Close results on click outside
    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('hidden');
        }
    });
</script>
<?php echo $__env->yieldContent('extra_js'); ?>
</body>
</html><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views/admin/layout/app.blade.php ENDPATH**/ ?>