<?php $__env->startSection('title', 'Log Attendance — Grace Church Staff'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-center gap-3 mb-6">
    <a href="<?php echo e(route('staff.attendance.index')); ?>" class="btn btn-ghost" style="padding:0.4rem 0.75rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
    </a>
    <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Log Attendance</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">

    
    <div class="card p-6">
        <h2 class="font-cinzel text-lg mb-4" style="color:var(--gold-mid)">Single Record</h2>
        <?php if($errors->any()): ?>
            <div class="mb-4 p-3 rounded bg-red-500/10 border border-red-500/20 text-red-500 text-sm">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p><?php echo e($error); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="<?php echo e(route('staff.attendance.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="space-y-4">
                <div>
                    <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Member *</label>
                    <select name="MemberID" class="form-input mt-1" required>
                        <option value="">Select member…</option>
                        <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($member->MemberID); ?>" <?php echo e(old('MemberID') == $member->MemberID ? 'selected' : ''); ?>>
                                <?php echo e($member->FirstName); ?> <?php echo e($member->LastName); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Status *</label>
                    <select name="Status" class="form-input mt-1" required>
                        <option value="Present" <?php echo e(old('Status','Present') === 'Present' ? 'selected' : ''); ?>>Present</option>
                        <option value="Absent"  <?php echo e(old('Status') === 'Absent'  ? 'selected' : ''); ?>>Absent</option>
                        <option value="Excused" <?php echo e(old('Status') === 'Excused' ? 'selected' : ''); ?>>Excused</option>
                    </select>
                </div>
                <div>
                    <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Date & Time *</label>
                    <input type="datetime-local" name="Timestamp"
                           value="<?php echo e(old('Timestamp', now()->format('Y-m-d\TH:i'))); ?>"
                           class="form-input mt-1" required>
                </div>
            </div>
            <div class="flex gap-3 mt-8">
                <button type="submit" class="btn btn-gold">Save Entry</button>
                <a href="<?php echo e(route('staff.attendance.index')); ?>" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>

    
    <div class="card p-6">
        <h2 class="font-cinzel text-lg mb-4" style="color:var(--gold-mid)">Bulk Entry Sheet</h2>
        <form method="POST" action="<?php echo e(route('staff.attendance.bulk')); ?>">
            <?php echo csrf_field(); ?>
            <div class="mb-6">
                <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Service / Session Date *</label>
                <input type="datetime-local" name="Timestamp"
                       value="<?php echo e(now()->format('Y-m-d\TH:i')); ?>"
                       class="form-input mt-1" required>
            </div>
            <div class="overflow-y-auto border border-white/5 rounded-lg mb-6" style="max-height:400px;">
                <table class="w-full text-left text-sm">
                    <thead class="sticky top-0 bg-panel text-[10px] uppercase font-bold tracking-widest" style="color:var(--gold-muted); z-index:10;">
                        <tr>
                            <th class="p-3">Member</th>
                            <th class="p-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                    <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="p-3">
                                <input type="hidden" name="records[<?php echo e($i); ?>][MemberID]" value="<?php echo e($member->MemberID); ?>">
                                <span class="font-medium"><?php echo e($member->FirstName); ?> <?php echo e($member->LastName); ?></span>
                            </td>
                            <td class="p-3">
                                <select name="records[<?php echo e($i); ?>][Status]" class="bg-black/20 border border-white/10 rounded px-2 py-1 text-xs outline-none focus:border-gold/50">
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
            <button type="submit" class="btn btn-gold w-full py-3">
                Save All (<?php echo e($members->count()); ?> members)
            </button>
        </form>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('staff.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\staff\attendance\create.blade.php ENDPATH**/ ?>