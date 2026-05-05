<?php $__env->startSection('title', 'Propose Event — Grace Church Staff'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-center gap-3 mb-6">
    <a href="<?php echo e(route('staff.events.index')); ?>" class="btn btn-ghost" style="padding:0.4rem 0.75rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
    </a>
    <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Propose Event</h1>
</div>

<div class="card p-6 max-w-xl">
    <div class="mb-6 p-4 bg-amber-500/10 border border-amber-500/20 rounded-lg">
        <p class="text-xs text-amber-500 font-bold uppercase tracking-wider flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            Pending Admin Review
        </p>
        <p class="text-xs mt-1 opacity-70">Events proposed by staff members are hidden from the public until approved by an administrator.</p>
    </div>

    <?php if($errors->any()): ?>
        <div class="alert-error mb-4">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p class="text-sm"><?php echo e($error); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('staff.events.store')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="flex flex-col gap-4">
            <div>
                <label class="form-label text-[11px] uppercase tracking-wider text-gold-muted mb-2 block">Title <span style="color:var(--red)">*</span></label>
                <input type="text" name="Title" value="<?php echo e(old('Title')); ?>" class="form-input" placeholder="e.g. Worship Night" required>
            </div>
            <div>
                <label class="form-label text-[11px] uppercase tracking-wider text-gold-muted mb-2 block">Location</label>
                <input type="text" name="Location" value="<?php echo e(old('Location')); ?>" class="form-input" placeholder="e.g. Main Hall">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label text-[11px] uppercase tracking-wider text-gold-muted mb-2 block">Start Date & Time <span style="color:var(--red)">*</span></label>
                    <input type="datetime-local" name="StartDateTime" value="<?php echo e(old('StartDateTime')); ?>" class="form-input" required>
                </div>
                <div>
                    <label class="form-label text-[11px] uppercase tracking-wider text-gold-muted mb-2 block">End Date & Time</label>
                    <input type="datetime-local" name="EndDateTime" value="<?php echo e(old('EndDateTime')); ?>" class="form-input">
                </div>
            </div>
            <div>
                <label class="form-label text-[11px] uppercase tracking-wider text-gold-muted mb-2 block">Event Banner / Photo</label>
                <input type="file" name="image" accept="image/*" class="form-input" style="padding:0.4rem 0.85rem">
                <p class="text-xs mt-1 opacity-50">JPG, PNG or GIF — max 2 MB</p>
            </div>
        </div>
        <div class="flex gap-3 mt-8">
            <button type="submit" class="btn btn-gold px-8 py-3">Submit for Approval</button>
            <a href="<?php echo e(route('staff.events.index')); ?>" class="btn btn-ghost px-8 py-3">Cancel</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('staff.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views/staff/events/create.blade.php ENDPATH**/ ?>