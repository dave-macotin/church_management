<?php $__env->startSection('title', 'Attendance History'); ?>
<?php $__env->startSection('page_title', 'Attendance History'); ?>

<?php $__env->startSection('content'); ?>
<div class="card overflow-hidden">
    <div class="data-table-container">
        <table>
            <thead>
                <tr>
                    <th>Date & Time</th>
                    <th>Event / Service</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="font-medium text-cream"><?php echo e($record->Timestamp->format('M d, Y')); ?></div>
                        <div class="text-xs text-gold-muted mt-0.5"><?php echo e($record->Timestamp->format('g:i A')); ?></div>
                    </td>
                    <td>
                        <div class="font-medium <?php echo e($record->event ? 'text-gold-mid' : 'text-cream'); ?>">
                            <?php echo e($record->event ? $record->event->Title : 'Regular Sunday Service'); ?>

                        </div>
                        <?php if($record->event && $record->event->Location): ?>
                            <div class="text-xs text-gold-muted mt-0.5 flex items-center gap-1.5">
                                <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2"/></svg>
                                <?php echo e($record->event->Location); ?>

                            </div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($record->Status === 'Present'): ?>
                            <span class="badge badge-green">Present</span>
                        <?php elseif($record->Status === 'Absent'): ?>
                            <span class="badge badge-red">Absent</span>
                        <?php else: ?>
                            <span class="badge badge-amber"><?php echo e($record->Status); ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="3">
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h4>No Attendance Records</h4>
                            <p>Weekly logs will appear here after each service or event attendance.</p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if($attendances->hasPages()): ?>
<div class="flex justify-center mt-6">
    <?php echo e($attendances->links()); ?>

</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('member.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views/member/attendance.blade.php ENDPATH**/ ?>