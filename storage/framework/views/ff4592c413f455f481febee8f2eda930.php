<?php $__env->startSection('title', 'Attendance History'); ?>
<?php $__env->startSection('page_title', 'Attendance History'); ?>

<?php $__env->startSection('content'); ?>
<div class="card" style="padding:0; overflow:hidden;">
    <div class="panel-header" style="padding:20px 24px;">
        <span class="panel-title">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            My Attendance Records
        </span>
    </div>
    
    <div style="overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse; font-size:14px; text-align:left;">
            <thead>
                <tr style="background:var(--bg-hover); border-bottom:1px solid var(--border);">
                    <th style="padding:16px 24px; color:var(--gold-muted); font-weight:600; text-transform:uppercase; font-size:11px; letter-spacing:0.05em;">Date & Time</th>
                    <th style="padding:16px 24px; color:var(--gold-muted); font-weight:600; text-transform:uppercase; font-size:11px; letter-spacing:0.05em;">Event / Service</th>
                    <th style="padding:16px 24px; color:var(--gold-muted); font-weight:600; text-transform:uppercase; font-size:11px; letter-spacing:0.05em;">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr style="border-bottom:1px solid var(--border-soft); transition:background 0.2s;" onmouseover="this.style.background='var(--bg-input)'" onmouseout="this.style.background='transparent'">
                    <td style="padding:16px 24px;">
                        <div style="color:var(--cream); font-weight:500;"><?php echo e($record->Timestamp->format('M d, Y')); ?></div>
                        <div style="font-size:12px; color:var(--gold-muted); margin-top:2px;"><?php echo e($record->Timestamp->format('g:i A')); ?></div>
                    </td>
                    <td style="padding:16px 24px;">
                        <div style="<?php echo e($record->event ? 'color:var(--gold-mid);' : 'color:var(--cream);'); ?> font-weight:500;">
                            <?php echo e($record->event ? $record->event->Title : 'Regular Sunday Service'); ?>

                        </div>
                        <?php if($record->event && $record->event->Location): ?>
                            <div style="font-size:12px; color:var(--gold-muted); margin-top:2px; display:flex; align-items:center; gap:4px;">
                                <svg style="width:10px;height:10px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2"/></svg>
                                <?php echo e($record->event->Location); ?>

                            </div>
                        <?php endif; ?>
                    </td>
                    <td style="padding:16px 24px;">
                        <span class="attendance-status <?php echo e(strtolower($record->Status)); ?>" style="display:inline-flex; align-items:center; gap:6px; padding:4px 12px; font-weight:600;">
                            <?php if($record->Status === 'Present'): ?>
                                <svg style="width:10px;height:10px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="2.5"/></svg>
                            <?php elseif($record->Status === 'Absent'): ?>
                                <svg style="width:10px;height:10px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2.5"/></svg>
                            <?php endif; ?>
                            <?php echo e($record->Status); ?>

                        </span>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="3" style="padding:48px; text-align:center; color:var(--gold-muted);">
                        <svg style="width:40px;height:40px;margin-bottom:12px;opacity:0.5;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <div style="font-size:15px; font-weight:500;">No attendance records found</div>
                        <div style="font-size:12px; margin-top:4px;">Weekly records will appear here after each service.</div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($attendances->hasPages()): ?>
    <div style="padding:20px 24px; border-top:1px solid var(--border-soft); display:flex; justify-content:center;">
        <?php echo e($attendances->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('member.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\member\attendance.blade.php ENDPATH**/ ?>