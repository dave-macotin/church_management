<?php $__env->startSection('title', 'My Dashboard'); ?>
<?php $__env->startSection('page_title', 'My Dashboard'); ?>

<?php $__env->startSection('extra_css'); ?>
<style>
    /* Attendance Summary Styles */
    .rate-container { position: relative; padding: 20px 0; display: flex; flex-direction: column; align-items: center; justify-content: center; }
    .rate-circle { position: relative; width: 140px; height: 140px; }
    .rate-circle svg { width: 100%; height: 100%; transform: rotate(-90deg); }
    .rate-track { fill: none; stroke: var(--bg-hover); stroke-width: 3; }
    .rate-fill { fill: none; stroke: var(--gold-bright); stroke-width: 3; stroke-linecap: round; transition: stroke-dashoffset 1s ease-out; }
    .rate-label { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); display: flex; flex-direction: column; align-items: center; }
    .rate-value { font-family: 'Outfit', sans-serif; font-size: 32px; font-weight: 800; color: var(--cream); line-height: 1; }
    .rate-text { font-size: 10px; text-transform: uppercase; letter-spacing: 0.1em; color: var(--gold-muted); margin-top: 4px; font-weight: 600; }
    
    .rate-breakdown { display: grid; grid-template-columns: 1fr; gap: 8px; margin-top: 24px; width: 100%; }
    .rate-item { display: flex; align-items: center; justify-content: space-between; padding: 10px 16px; background: rgba(255,255,255,0.02); border: 1px solid var(--border-soft); border-radius: 12px; transition: all 0.2s; }
    .rate-item:hover { background: rgba(255,255,255,0.04); border-color: var(--border); transform: translateX(4px); }
    .rate-item .lbl-wrap { display: flex; align-items: center; gap: 10px; }
    .rate-item .dot { width: 8px; height: 8px; border-radius: 50%; }
    .rate-item.p .dot { background: var(--green); box-shadow: 0 0 10px var(--green); }
    .rate-item.a .dot { background: var(--red); box-shadow: 0 0 10px var(--red); }
    .rate-item.e .dot { background: var(--gold-muted); }
    .rate-item .lbl { font-size: 12px; font-weight: 500; color: var(--gold-muted); }
    .rate-item .val { font-family: 'Outfit', sans-serif; font-size: 14px; font-weight: 700; color: var(--cream); }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
    
    <div style="background:linear-gradient(90deg, var(--bg-card) 0%, transparent 100%); border:1px solid var(--border); border-radius:12px; padding:20px 24px; display:flex; align-items:center; gap:20px; margin-bottom:32px; box-shadow:var(--shadow);">
        <div style="width:48px; height:48px; background:var(--gold-bright); color:#000; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:0 0 20px rgba(239,159,39,0.3);">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
        </div>
        <div>
            <div style="font-size:16px; font-weight:500; color:var(--cream); line-height:1.5; font-style:italic;">"You armed me with strength for battle; you humbled my adversaries before me."</div>
            <div style="font-size:12px; color:var(--gold-muted); margin-top:4px; font-weight:600; text-transform:uppercase; letter-spacing:0.05em;">— Psalm 18:39</div>
        </div>
    </div>

    
    <div class="welcome-banner" style="background:linear-gradient(135deg, var(--bg-card) 0%, var(--bg-panel) 100%); border:1px solid var(--border); border-radius:16px; padding:32px; display:flex; align-items:center; gap:24px; margin-bottom:32px; position:relative; overflow:hidden;">
        <div style="position:absolute; top:-20px; right:-20px; width:150px; height:150px; background:var(--accent-glow); border-radius:50%; filter:blur(40px); opacity:0.5;"></div>
        <div class="welcome-avatar" style="width:80px; height:80px; border-radius:50%; border:3px solid var(--gold-bright); <?php echo e(auth()->user()->member?->profile_picture ? 'background-image:url('.asset('storage/'.auth()->user()->member->profile_picture).'); background-size:cover; background-position:center; color:transparent;' : 'background:var(--bg-hover); display:flex; align-items:center; justify-content:center; font-size:32px; font-weight:700; color:var(--gold-bright); font-family:Outfit;'); ?>">
            <?php echo e(!auth()->user()->member?->profile_picture ? strtoupper(substr(auth()->user()->first_name ?? 'M', 0, 1)) : ''); ?>

        </div>
        <div class="welcome-text" style="flex:1;">
            <div class="welcome-greeting" style="color:var(--gold-muted); font-size:14px; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:4px;">Peace be with you,</div>
            <div class="welcome-name" style="font-size:32px; font-weight:700; color:var(--cream); line-height:1.2;"><?php echo e(auth()->user()->first_name ?? 'Beloved Member'); ?></div>
            <div class="welcome-sub" style="font-size:13px; color:var(--gold-muted); margin-top:6px;">Faithful member since <?php echo e(auth()->user()->member?->created_at?->format('F Y') ?? 'this blessed year'); ?></div>
        </div>
        <div class="welcome-badge" style="background:var(--green-bg); color:var(--green); border:1px solid rgba(93,202,165,0.2); padding:8px 16px; border-radius:99px; font-size:12px; font-weight:600; display:flex; align-items:center; gap:8px;">
            <span style="width:8px; height:8px; background:var(--green); border-radius:50%; box-shadow:0 0 8px var(--green);"></span>
            Active Disciple
        </div>
    </div>

    
    
    <div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:20px; margin-bottom:32px;">
        <a href="<?php echo e(route('member.attendance')); ?>" class="btn" style="background:var(--bg-card); border:1px solid var(--border); padding:24px; flex-direction:column; align-items:center; height:auto; gap:16px; transition:all 0.3s; border-radius:20px; box-shadow:0 4px 15px rgba(0,0,0,0.1);" onmouseover="this.style.background='var(--bg-hover)'; this.style.borderColor='var(--green)'; this.style.transform='translateY(-4px)'" onmouseout="this.style.background='var(--bg-card)'; this.style.borderColor='var(--border)'; this.style.transform='translateY(0)'">
            <span style="background:var(--green-bg); color:var(--green); width:56px; height:56px; border-radius:16px; display:flex; align-items:center; justify-content:center; transition:transform 0.3s;" class="icon-box">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            </span>
            <div style="font-family:Outfit; font-weight:700; color:var(--cream); font-size:15px; letter-spacing:0.02em;">Attendance</div>
        </a>
        <a href="<?php echo e(route('member.events')); ?>" class="btn" style="background:var(--bg-card); border:1px solid var(--border); padding:24px; flex-direction:column; align-items:center; height:auto; gap:16px; transition:all 0.3s; border-radius:20px; box-shadow:0 4px 15px rgba(0,0,0,0.1);" onmouseover="this.style.background='var(--bg-hover)'; this.style.borderColor='var(--blue)'; this.style.transform='translateY(-4px)'" onmouseout="this.style.background='var(--bg-card)'; this.style.borderColor='var(--border)'; this.style.transform='translateY(0)'">
            <span style="background:var(--blue-bg); color:var(--blue); width:56px; height:56px; border-radius:16px; display:flex; align-items:center; justify-content:center; transition:transform 0.3s;" class="icon-box">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </span>
            <div style="font-family:Outfit; font-weight:700; color:var(--cream); font-size:15px; letter-spacing:0.02em;">Events</div>
        </a>
        <a href="<?php echo e(route('member.groups')); ?>" class="btn" style="background:var(--bg-card); border:1px solid var(--border); padding:24px; flex-direction:column; align-items:center; height:auto; gap:16px; transition:all 0.3s; border-radius:20px; box-shadow:0 4px 15px rgba(0,0,0,0.1);" onmouseover="this.style.background='var(--bg-hover)'; this.style.borderColor='var(--purple)'; this.style.transform='translateY(-4px)'" onmouseout="this.style.background='var(--bg-card)'; this.style.borderColor='var(--border)'; this.style.transform='translateY(0)'">
            <span style="background:var(--purple-bg); color:var(--purple); width:56px; height:56px; border-radius:16px; display:flex; align-items:center; justify-content:center; transition:transform 0.3s;" class="icon-box">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </span>
            <div style="font-family:Outfit; font-weight:700; color:var(--cream); font-size:15px; letter-spacing:0.02em;">Community</div>
        </a>
        <a href="<?php echo e(route('member.donations')); ?>" class="btn" style="background:var(--bg-card); border:1px solid var(--border); padding:24px; flex-direction:column; align-items:center; height:auto; gap:16px; transition:all 0.3s; border-radius:20px; box-shadow:0 4px 15px rgba(0,0,0,0.1);" onmouseover="this.style.background='var(--bg-hover)'; this.style.borderColor='var(--gold-bright)'; this.style.transform='translateY(-4px)'" onmouseout="this.style.background='var(--bg-card)'; this.style.borderColor='var(--border)'; this.style.transform='translateY(0)'">
            <span style="background:var(--gold-bright); color:#000; width:56px; height:56px; border-radius:16px; display:flex; align-items:center; justify-content:center; transition:transform 0.3s;" class="icon-box">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </span>
            <div style="font-family:Outfit; font-weight:700; color:var(--cream); font-size:15px; letter-spacing:0.02em;">Giving</div>
        </a>
    </div>

    <div class="stats-grid" style="display:grid; grid-template-columns:repeat(4, 1fr); gap:20px; margin-bottom:32px;">
        <div class="stat-card" style="background:linear-gradient(145deg, var(--bg-card) 0%, #1a0f05 100%); border:1px solid var(--border); border-radius:20px; padding:24px; transition:all 0.3s ease; cursor:default; box-shadow:0 10px 30px rgba(0,0,0,0.15);" onmouseover="this.style.transform='translateY(-8px)'; this.style.borderColor='var(--gold-bright)'" onmouseout="this.style.transform='none'; this.style.borderColor='var(--border)'">
            <div class="stat-header" style="display:flex; justify-content:space-between; margin-bottom:16px;">
                <span class="stat-icon" style="color:var(--gold-bright); background:rgba(239,159,39,0.1); width:40px; height:40px; border-radius:12px; display:flex; align-items:center; justify-content:center;"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></span>
                <span class="stat-trend <?php echo e($attendanceRate >= 80 ? 'up' : 'down'); ?>" style="color:<?php echo e($attendanceRate >= 80 ? 'var(--green)' : 'var(--red)'); ?>; font-size:11px; font-weight:700; background:<?php echo e($attendanceRate >= 80 ? 'var(--green-bg)' : 'var(--red-bg)'); ?>; padding:2px 8px; border-radius:20px;"><?php echo e($attendanceRate >= 80 ? '↑ Robust' : '↓ Low'); ?></span>
            </div>
            <div class="stat-value" style="font-size:38px; font-weight:800; color:var(--cream); font-family:Outfit; letter-spacing:-0.02em;"><?php echo e($attendanceRate); ?><span style="font-size:16px; color:var(--gold-muted); font-weight:500; margin-left:2px;">%</span></div>
            <div class="stat-label" style="font-size:11px; color:var(--gold-muted); text-transform:uppercase; letter-spacing:0.1em; margin-top:6px; font-weight:600;">Attendance Consistency</div>
        </div>

        <div class="stat-card" style="background:linear-gradient(145deg, var(--bg-card) 0%, #1a0f05 100%); border:1px solid var(--border); border-radius:20px; padding:24px; transition:all 0.3s ease; cursor:default; box-shadow:0 10px 30px rgba(0,0,0,0.15);" onmouseover="this.style.transform='translateY(-8px)'; this.style.borderColor='var(--blue)'" onmouseout="this.style.transform='none'; this.style.borderColor='var(--border)'">
            <div class="stat-header" style="display:flex; justify-content:space-between; margin-bottom:16px;">
                <span class="stat-icon" style="color:var(--blue); background:rgba(123,184,232,0.1); width:40px; height:40px; border-radius:12px; display:flex; align-items:center; justify-content:center;"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></span>
                <span style="color:var(--blue); font-size:11px; font-weight:700; background:var(--blue-bg); padding:2px 8px; border-radius:20px;">Upcoming</span>
            </div>
            <div class="stat-value" style="font-size:38px; font-weight:800; color:var(--cream); font-family:Outfit; letter-spacing:-0.02em;"><?php echo e($upcomingCount); ?></div>
            <div class="stat-label" style="font-size:11px; color:var(--gold-muted); text-transform:uppercase; letter-spacing:0.1em; margin-top:6px; font-weight:600;">Fellowship Gatherings</div>
        </div>

        <div class="stat-card" style="background:linear-gradient(145deg, var(--bg-card) 0%, #1a0f05 100%); border:1px solid var(--border); border-radius:20px; padding:24px; transition:all 0.3s ease; cursor:default; box-shadow:0 10px 30px rgba(0,0,0,0.15);" onmouseover="this.style.transform='translateY(-8px)'; this.style.borderColor='var(--purple)'" onmouseout="this.style.transform='none'; this.style.borderColor='var(--border)'">
            <div class="stat-header" style="display:flex; justify-content:space-between; margin-bottom:16px;">
                <span class="stat-icon" style="color:var(--purple); background:rgba(184,159,232,0.1); width:40px; height:40px; border-radius:12px; display:flex; align-items:center; justify-content:center;"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></span>
                <span style="color:var(--purple); font-size:11px; font-weight:700; background:var(--purple-bg); padding:2px 8px; border-radius:20px;">Connected</span>
            </div>
            <div class="stat-value" style="font-size:38px; font-weight:800; color:var(--cream); font-family:Outfit; letter-spacing:-0.02em;"><?php echo e($groupCount); ?></div>
            <div class="stat-label" style="font-size:11px; color:var(--gold-muted); text-transform:uppercase; letter-spacing:0.1em; margin-top:6px; font-weight:600;">Community Groups</div>
        </div>

        <div class="stat-card" style="background:linear-gradient(145deg, var(--bg-card) 0%, #1a0f05 100%); border:1px solid var(--border); border-radius:20px; padding:24px; transition:all 0.3s ease; cursor:default; box-shadow:0 10px 30px rgba(0,0,0,0.15);" onmouseover="this.style.transform='translateY(-8px)'; this.style.borderColor='var(--green)'" onmouseout="this.style.transform='none'; this.style.borderColor='var(--border)'">
            <div class="stat-header" style="display:flex; justify-content:space-between; margin-bottom:16px;">
                <span class="stat-icon" style="color:var(--green); background:rgba(93,202,165,0.1); width:40px; height:40px; border-radius:12px; display:flex; align-items:center; justify-content:center;"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z"/><path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zM4 12c0-4.418 3.582-8 8-8s8 3.582 8 8-3.582 8-8 8-8-3.582-8-8z"/></svg></span>
                <span style="color:var(--green); font-size:11px; font-weight:700; background:var(--green-bg); padding:2px 8px; border-radius:20px;">Blessed</span>
            </div>
            <div class="stat-value" style="font-size:38px; font-weight:800; color:var(--cream); font-family:Outfit; letter-spacing:-0.02em;">₱<?php echo e(number_format($totalDonations, 0)); ?></div>
            <div class="stat-label" style="font-size:11px; color:var(--gold-muted); text-transform:uppercase; letter-spacing:0.1em; margin-top:6px; font-weight:600;">Kingdom Giving</div>
        </div>
    </div>

    
    <div class="content-grid wide" style="display:grid; grid-template-columns: 2fr 1fr; gap:24px;">
        <div style="display:flex; flex-direction:column; gap:24px;">
            
            <div class="panel" style="background:var(--bg-card); border:1px solid var(--border); border-radius:20px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.15);">
                <div class="panel-header" style="padding:24px; border-bottom:1px solid var(--border-soft); display:flex; justify-content:space-between; align-items:center; background:linear-gradient(90deg, rgba(239,159,39,0.05) 0%, transparent 100%);">
                    <span class="panel-title" style="font-family:Outfit; font-size:16px; font-weight:600; color:var(--gold-mid); display:flex; align-items:center; gap:10px;">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"/></svg> 
                        Sacred Gatherings
                    </span>
                    <a href="<?php echo e(route('member.events')); ?>" class="panel-action" style="color:var(--gold-bright); font-size:12px; font-weight:600; text-decoration:none; text-transform:uppercase; letter-spacing:0.05em;">View all history</a>
                </div>
                <div class="panel-body" style="padding:8px 0;">
                    <?php $__empty_1 = true; $__currentLoopData = $upcomingEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="event-item" style="padding:16px 24px; display:flex; align-items:center; gap:16px; border-bottom:1px solid var(--border-soft); transition:background 0.2s;" onmouseover="this.style.background='var(--bg-hover)'" onmouseout="this.style.background='transparent'">
                            <div class="event-date-badge" style="width:50px; height:50px; background:var(--bg-input); border:1px solid var(--border); border-radius:12px; display:flex; flex-direction:column; align-items:center; justify-content:center; flex-shrink:0;">
                                <div class="day" style="font-size:18px; font-weight:700; color:var(--gold-bright); font-family:Outfit; line-height:1;"><?php echo e($event->StartDateTime->format('d')); ?></div>
                                <div class="mon" style="font-size:10px; font-weight:600; color:var(--gold-muted); text-transform:uppercase; margin-top:2px;"><?php echo e($event->StartDateTime->format('M')); ?></div>
                            </div>
                            <div class="event-info" style="flex:1;">
                                <div class="event-title" style="font-size:15px; font-weight:600; color:var(--cream); margin-bottom:4px; font-family:Outfit;"><?php echo e($event->Title); ?></div>
                                <div class="event-meta" style="display:flex; align-items:center; gap:12px; font-size:12px; color:var(--gold-muted);">
                                    <span style="display:flex; align-items:center; gap:4px;"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/></svg> <?php echo e($event->StartDateTime->format('g:i A')); ?></span>
                                    <span style="display:flex; align-items:center; gap:4px;"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2"/></svg> <?php echo e($event->Location ?? 'Sanctuary'); ?></span>
                                </div>
                            </div>
                            <span class="event-chip <?php echo e($event->StartDateTime->isToday() ? 'today' : 'upcoming'); ?>" style="background:<?php echo e($event->StartDateTime->isToday() ? 'var(--blue-bg)' : 'var(--bg-input)'); ?>; color:<?php echo e($event->StartDateTime->isToday() ? 'var(--blue)' : 'var(--gold-muted)'); ?>; padding:4px 10px; border-radius:6px; font-size:11px; font-weight:600; border:1px solid <?php echo e($event->StartDateTime->isToday() ? 'rgba(123,184,232,0.2)' : 'var(--border)'); ?>;">
                                <?php echo e($event->StartDateTime->isToday() ? 'Today' : $event->StartDateTime->diffForHumans()); ?>

                            </span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div style="text-align:center; padding:40px; color:var(--gold-muted); font-size:14px; font-style:italic;">No upcoming holy gatherings scheduled.</div>
                    <?php endif; ?>
                </div>
            </div>
 </div>

            
            <div class="panel" style="background:var(--bg-card); border:1px solid var(--border); border-radius:16px; overflow:hidden; box-shadow:var(--shadow);">
                <div class="panel-header" style="padding:20px 24px; border-bottom:1px solid var(--border-soft); display:flex; justify-content:space-between; align-items:center;">
                    <span class="panel-title" style="font-family:Outfit; font-size:16px; font-weight:600; color:var(--gold-mid); display:flex; align-items:center; gap:10px;">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg> 
                        Attendance History
                    </span>
                    <a href="<?php echo e(route('member.attendance')); ?>" class="panel-action" style="color:var(--gold-bright); font-size:12px; font-weight:600; text-decoration:none; text-transform:uppercase; letter-spacing:0.05em;">View full report</a>
                </div>
                <div class="panel-body" style="padding:8px 0;">
                    <?php $__empty_1 = true; $__currentLoopData = $recentAttendance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="attendance-row" style="padding:12px 24px; display:flex; align-items:center; gap:16px; border-bottom:1px solid var(--border-soft); transition:all 0.2s;" onmouseover="this.style.background='var(--bg-hover)'" onmouseout="this.style.background='transparent'">
                            <div class="attendance-status-indicator" style="width:10px; height:10px; border-radius:50%; background:<?php echo e($record->Status === 'Present' ? 'var(--green)' : 'var(--red)'); ?>; box-shadow:0 0 10px <?php echo e($record->Status === 'Present' ? 'rgba(93,202,165,0.4)' : 'rgba(240,153,123,0.4)'); ?>; flex-shrink:0;"></div>
                            <div class="attendance-info" style="flex:1;">
                                <div class="attendance-event" style="font-size:14px; font-weight:600; color:var(--cream); font-family:Outfit;"><?php echo e($record->event ? $record->event->Title : 'Sacred Sunday Service'); ?></div>
                                <div class="attendance-date" style="font-size:12px; color:var(--gold-muted);"><?php echo e($record->Timestamp->format('M d, Y')); ?></div>
                            </div>
                            <span class="attendance-status-label" style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:<?php echo e($record->Status === 'Present' ? 'var(--green)' : 'var(--red)'); ?>; opacity:0.8;"><?php echo e($record->Status); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div style="text-align:center; padding:40px; color:var(--gold-muted); font-size:14px; font-style:italic;">No attendance history available yet.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div style="display:flex; flex-direction:column; gap:20px;">
            
            <div class="panel" style="background:var(--bg-card); border:1px solid var(--border); border-radius:20px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.15);">
                <div class="panel-header" style="padding:24px; border-bottom:1px solid var(--border-soft); background:linear-gradient(90deg, rgba(239,159,39,0.05) 0%, transparent 100%);">
                    <span class="panel-title" style="font-family:Outfit; font-size:16px; font-weight:600; color:var(--gold-mid); display:flex; align-items:center; gap:10px;">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg> 
                        Attendance Summary
                    </span>
                </div>
                <div class="panel-body" style="padding:24px;">
                    <div class="rate-container">
                        <div class="rate-circle">
                            <svg viewBox="0 0 36 36">
                                <circle class="rate-track" cx="18" cy="18" r="14"/>
                                <circle class="rate-fill" cx="18" cy="18" r="14" stroke-dasharray="87.96" stroke-dashoffset="<?php echo e(87.96 - (87.96 * $attendanceRate / 100)); ?>"/>
                            </svg>
                            <div class="rate-label">
                                <span class="rate-value"><?php echo e($attendanceRate); ?>%</span>
                                <span class="rate-text">Consistency</span>
                            </div>
                        </div>

                        <div class="rate-breakdown">
                            <div class="rate-item p">
                                <div class="lbl-wrap"><span class="dot"></span><span class="lbl">Present</span></div>
                                <div class="val"><?php echo e($presentCount); ?></div>
                            </div>
                            <div class="rate-item a">
                                <div class="lbl-wrap"><span class="dot"></span><span class="lbl">Absent</span></div>
                                <div class="val"><?php echo e($absentCount); ?></div>
                            </div>
                            <div class="rate-item e">
                                <div class="lbl-wrap"><span class="dot"></span><span class="lbl">Excused</span></div>
                                <div class="val"><?php echo e($excusedCount); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="panel" style="background:var(--bg-card); border:1px solid var(--border); border-radius:16px; overflow:hidden; box-shadow:var(--shadow);">
                <div class="panel-header" style="padding:20px 24px; border-bottom:1px solid var(--border-soft);">
                    <span class="panel-title" style="font-family:Outfit; font-size:16px; font-weight:600; color:var(--gold-mid); display:flex; align-items:center; gap:10px;">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/></svg> 
                        Fellowship Groups
                    </span>
                </div>
                <div class="panel-body" style="padding:16px 24px;">
                    <?php $__empty_1 = true; $__currentLoopData = $myGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="group-item" style="display:flex; align-items:center; gap:16px; margin-bottom:16px; last-child:margin-bottom:0;">
                            <div class="group-icon" style="width:40px; height:40px; background:var(--bg-hover); border:1px solid var(--border); border-radius:12px; display:flex; align-items:center; justify-content:center; color:var(--gold-bright); flex-shrink:0;">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" stroke-width="2"/></svg>
                            </div>
                            <div style="flex:1;">
                                <div class="group-name" style="font-size:15px; font-weight:600; color:var(--cream); font-family:Outfit;"><?php echo e($group->GroupName); ?></div>
                                <div class="group-desc" style="font-size:12px; color:var(--gold-muted); margin-top:2px;"><?php echo e(Str::limit($group->Description, 60)); ?></div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div style="text-align:center; padding:24px 0; color:var(--gold-muted); font-size:14px; font-style:italic;">You are not currently part of any community groups.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('member.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views/member/dashboard.blade.php ENDPATH**/ ?>