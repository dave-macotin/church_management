<?php $__env->startSection('title', 'Archived Attendance — Grace Church CMS'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Archived Attendance</h1>
        <p class="text-sm mt-1" style="color:var(--text-muted)"><?php echo e($attendances->total()); ?> archived records</p>
    </div>
    <a href="<?php echo e(route('admin.attendance.index')); ?>" class="btn btn-ghost">← Back to Active</a>
</div>

<div class="card overflow-hidden">
    <table>
        <thead>
            <tr>
                <th>Member</th>
                <th>Event</th>
                <th>Status</th>
                <th>Archived On</th>
                <th style="text-align:right">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr style="opacity:0.75">
                <td>
                    <span class="font-medium"><?php echo e($att->member ? $att->member->FirstName . ' ' . $att->member->LastName : '—'); ?></span>
                </td>
                <td style="color:var(--text-muted)"><?php echo e($att->event?->Title ?? 'Service/Gathering'); ?></td>
                <td>
                    <?php if($att->Status === 'Present'): ?>
                        <span class="badge badge-green">Present</span>
                    <?php elseif($att->Status === 'Absent'): ?>
                        <span class="badge badge-red">Absent</span>
                    <?php else: ?>
                        <span class="badge badge-amber">Excused</span>
                    <?php endif; ?>
                </td>
                <td style="color:var(--text-muted)"><?php echo e($att->deleted_at->format('M d, Y')); ?></td>
                <td style="text-align:right">
                    <form method="POST" action="<?php echo e(route('admin.attendance.restore', $att->AttendanceID)); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-ghost" style="padding:0.35rem 0.7rem;font-size:0.8rem;color:var(--green);border-color:var(--green)">Restore</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="5" class="text-center py-12" style="color:var(--text-muted)">No archived records.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="flex justify-end mt-4 pagination"><?php echo e($attendances->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.Layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\admin\Ministry\Attendance\archived.blade.php ENDPATH**/ ?>