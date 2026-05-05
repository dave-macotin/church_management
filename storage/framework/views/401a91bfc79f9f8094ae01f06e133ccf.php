
<?php $__env->startSection('title', 'Log Attendance — Grace Church CMS'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-center gap-3 mb-6">
    <a href="<?php echo e(route('admin.attendance.index')); ?>" class="btn btn-ghost" style="padding:0.4rem 0.75rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
    </a>
    <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Log Attendance</h1>
</div>

<div class="flex gap-6 items-start">

    
    <div class="card p-6 flex-1">
        <h2 class="font-cinzel text-lg mb-4" style="color:var(--gold-light)">Single Record</h2>
        <?php if($errors->any()): ?>
            <div class="alert-error mb-4">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p class="text-sm"><?php echo e($error); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="<?php echo e(route('admin.attendance.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="flex flex-col gap-4">
                <div>
                    <label class="form-label">Member <span style="color:var(--red)">*</span></label>
                    <select name="MemberID" class="form-input" required>
                        <option value="">Select member…</option>
                        <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($member->MemberID); ?>" <?php echo e(old('MemberID') == $member->MemberID ? 'selected' : ''); ?>>
                                <?php echo e($member->FirstName); ?> <?php echo e($member->LastName); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="form-label">Status <span style="color:var(--red)">*</span></label>
                    <select name="Status" class="form-input" required>
                        <option value="Present" <?php echo e(old('Status','Present') === 'Present' ? 'selected' : ''); ?>>Present</option>
                        <option value="Absent"  <?php echo e(old('Status') === 'Absent'  ? 'selected' : ''); ?>>Absent</option>
                        <option value="Excused" <?php echo e(old('Status') === 'Excused' ? 'selected' : ''); ?>>Excused</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Date & Time <span style="color:var(--red)">*</span></label>
                    <input type="datetime-local" name="Timestamp"
                           value="<?php echo e(old('Timestamp', now()->format('Y-m-d\TH:i'))); ?>"
                           class="form-input" required>
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="submit" class="btn btn-gold">Save</button>
                <a href="<?php echo e(route('admin.attendance.index')); ?>" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>

    
    <div class="card p-6 flex-1">
        <h2 class="font-cinzel text-lg mb-4" style="color:var(--gold-light)">Bulk Sheet</h2>
        <form method="POST" action="<?php echo e(route('admin.attendance.bulk')); ?>">
            <?php echo csrf_field(); ?>
            <div class="mb-4">
                <label class="form-label">Service / Session Date <span style="color:var(--red)">*</span></label>
                <input type="datetime-local" name="Timestamp"
                       value="<?php echo e(now()->format('Y-m-d\TH:i')); ?>"
                       class="form-input" required>
            </div>
            <div class="card overflow-hidden mb-4" style="max-height:380px;overflow-y:auto">
                <table>
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th style="text-align:center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <input type="hidden" name="records[<?php echo e($i); ?>][MemberID]" value="<?php echo e($member->MemberID); ?>">
                                <?php echo e($member->FirstName); ?> <?php echo e($member->LastName); ?>

                            </td>
                            <td>
                                <select name="records[<?php echo e($i); ?>][Status]" class="form-input" style="padding:0.3rem 0.5rem;font-size:0.8rem">
                                    <option value="Present">Present</option>
                                    <option value="Absent">Absent</option>
                                    <option value="Excused">Excused</option>
                                </select>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-gold w-full" style="justify-content:center">
                Save All (<?php echo e($members->count()); ?> members)
            </button>
        </form>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.Layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\admin\Ministry\Attendance\create.blade.php ENDPATH**/ ?>