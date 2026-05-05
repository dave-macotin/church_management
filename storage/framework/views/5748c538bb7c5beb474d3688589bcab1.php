<?php $__env->startSection('title', 'Church Events'); ?>
<?php $__env->startSection('page_title', 'Church Events'); ?>

<?php $__env->startSection('extra_css'); ?>
<style>
    .events-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 24px; }
    .event-card { transition: transform 0.2s, border-color 0.2s; position: relative; overflow: hidden; }
    .event-card:hover { transform: translateY(-5px); border-color: rgba(239, 159, 39, 0.4); }
    .event-banner { height: 120px; background: linear-gradient(135deg, #2a160a 0%, #1a0f05 100%); position: relative; display: flex; align-items: center; justify-content: center; overflow: hidden; }
    .event-banner::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 1px; background: var(--border); }
    .event-type-badge { position: absolute; top: 12px; right: 12px; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); color: var(--gold-mid); font-size: 10px; padding: 4px 10px; border-radius: 99px; border: 1px solid var(--border); }
    .event-body { padding: 20px; }
    .event-date { font-weight: 700; color: var(--gold-bright); font-family: Georgia, serif; font-size: 13px; margin-bottom: 8px; text-transform: uppercase; }
    .event-h3 { font-family: Georgia, serif; font-size: 18px; color: var(--cream); margin-bottom: 12px; }
    .event-loc { font-size: 13px; color: var(--gold-muted); display: flex; align-items: center; gap: 6px; margin-bottom: 20px; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div style="margin-bottom:40px;">
    <h3 style="font-family:Georgia, serif; font-size:20px; color:var(--gold-mid); margin-bottom:24px; display:flex; align-items:center; gap:12px;">
        <svg style="width:20px;height:20px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        Upcoming Events
    </h3>

    <div class="events-grid">
        <?php $__empty_1 = true; $__currentLoopData = $upcomingEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="card event-card">
            <div class="event-banner">
                <svg style="width:48px; height:48px; opacity:0.1; color:var(--gold-bright);" fill="currentColor" viewBox="0 0 24 24"><path d="M19 4H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-7 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm6 12H6v-1c0-2 4-3.1 6-3.1s6 1.1 6 3.1v1z"/></svg>
                <div class="event-type-badge">Church Event</div>
            </div>
            <div class="event-body">
                <div class="event-date">
                    <svg style="width:12px;height:12px;margin-bottom:-1px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2"/></svg>
                    <?php echo e($event->StartDateTime->format('M d, Y')); ?> • <?php echo e($event->StartDateTime->format('g:i A')); ?>

                </div>
                <h3 class="event-h3"><?php echo e($event->Title); ?></h3>
                <div class="event-loc">
                    <svg style="width:12px;height:12px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/></svg>
                    <?php echo e($event->Location ?? 'Grace Church Hall'); ?>

                </div>

                <div style="margin-top:20px; border-top:1px solid var(--border-soft); padding-top:16px;">
                    <?php 
                        $isRegistered = in_array($event->EventID, $registeredEventIds); 
                        $attendance = $eventAttendances[$event->EventID] ?? null;
                    ?>
                    
                    <?php if($isRegistered): ?>
                        <?php if(!$attendance || !$attendance->CheckInTime): ?>
                            <div style="display:flex; flex-direction:column; gap:12px;">
                                <div style="display:flex; justify-content:space-between; align-items:center;">
                                    <span style="font-size:12px; color:var(--green); display:flex; align-items:center; gap:6px;">
                                        <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/></svg>
                                        Registered
                                    </span>
                                    <form action="<?php echo e(route('member.events.cancel', $event->EventID)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-ghost" style="padding:6px 12px; font-size:11px; border:none; color:var(--red); opacity:0.7;">Cancel</button>
                                    </form>
                                </div>
                                <form action="<?php echo e(route('member.events.checkin', $event->EventID)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-gold" style="width:100%; gap:8px;">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Check In Now
                                    </button>
                                </form>
                            </div>
                        <?php elseif(!$attendance->CheckOutTime): ?>
                            <div style="display:flex; flex-direction:column; gap:10px;">
                                <div style="font-size:11px; color:var(--green); background:var(--green-bg); padding:10px 14px; border-radius:8px; display:flex; align-items:center; justify-content:space-between; border:1px solid rgba(93,202,165,0.2);">
                                    <span style="display:flex; align-items:center; gap:8px;">
                                        <span style="width:6px; height:6px; background:var(--green); border-radius:50%; box-shadow:0 0 8px var(--green);"></span>
                                        Currently Attending
                                    </span>
                                    <strong><?php echo e($attendance->CheckInTime->format('g:i A')); ?></strong>
                                </div>
                                <form action="<?php echo e(route('member.events.checkout', $event->EventID)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-ghost" style="width:100%; gap:8px; border-color:var(--red); color:var(--red); background:var(--red-bg);">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Check Out
                                    </button>
                                </form>
                            </div>
                        <?php else: ?>
                            <div style="background:var(--bg-input); padding:14px; border-radius:10px; border:1px solid var(--border); display:flex; flex-direction:column; gap:8px;">
                                <div style="font-size:12px; color:var(--gold-mid); font-weight:600; text-transform:uppercase; letter-spacing:0.05em; display:flex; align-items:center; gap:6px;">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Attendance Logged
                                </div>
                                <div style="display:flex; justify-content:space-between; font-size:11px; color:var(--gold-muted); padding:0 4px;">
                                    <span>Joined: <?php echo e($attendance->CheckInTime->format('g:i A')); ?></span>
                                    <span>Left: <?php echo e($attendance->CheckOutTime->format('g:i A')); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <form action="<?php echo e(route('member.events.join', $event->EventID)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-gold" style="width:100%; padding:12px; font-weight:700; letter-spacing:0.02em;">Register for Event</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div style="grid-column:1/-1; text-align:center; padding:60px; background:var(--bg-card); border-radius:var(--radius); border:1px dashed var(--border);">
            <div style="color:var(--gold-muted); font-size:14px;">No upcoming events at the moment. Check back later!</div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php if($pastEvents->count() > 0): ?>
<div>
    <h3 style="font-family:Georgia, serif; font-size:18px; color:var(--gold-muted); margin-bottom:20px;">Past Events</h3>
    <div class="card" style="padding:0;">
        <table style="width:100%; border-collapse:collapse; font-size:13px; text-align:left;">
            <tbody>
                <?php $__currentLoopData = $pastEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr style="border-bottom:1px solid var(--border-soft);">
                    <td style="padding:14px 24px; color:var(--cream);"><?php echo e($event->Title); ?></td>
                    <td style="padding:14px 24px; color:var(--gold-muted);"><?php echo e($event->StartDateTime->format('M d, Y')); ?></td>
                    <td style="padding:14px 24px; color:var(--gold-muted);"><?php echo e($event->Location ?? 'N/A'); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px;">
        <?php echo e($pastEvents->links()); ?>

    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('member.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\member\events.blade.php ENDPATH**/ ?>