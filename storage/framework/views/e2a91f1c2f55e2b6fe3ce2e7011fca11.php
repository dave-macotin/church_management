
<?php $__env->startSection('title', 'Add Group — Grace Church CMS'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-center gap-3 mb-6">
    <a href="<?php echo e(route('admin.groups.index')); ?>" class="btn btn-ghost" style="padding:0.4rem 0.75rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
    </a>
    <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Add Group</h1>
</div>

<div class="card p-6 max-w-xl">
    <?php if($errors->any()): ?>
        <div class="alert-error mb-4">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p class="text-sm"><?php echo e($error); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
    <form method="POST" action="<?php echo e(route('admin.groups.store')); ?>">
        <?php echo csrf_field(); ?>
        <div class="flex flex-col gap-4">
            <div>
                <label class="form-label">Group Name <span style="color:var(--red)">*</span></label>
                <input type="text" name="GroupName" value="<?php echo e(old('GroupName')); ?>" class="form-input" required>
            </div>
            <div>
                <label class="form-label">Description</label>
                <textarea name="Description" rows="3" class="form-input" style="resize:vertical"><?php echo e(old('Description')); ?></textarea>
            </div>
            <div>
                <label class="form-label">Linked Event (optional)</label>
                <select name="EventID" class="form-input">
                    <option value="">— None —</option>
                    <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($event->EventID); ?>" <?php echo e(old('EventID') == $event->EventID ? 'selected' : ''); ?>>
                            <?php echo e($event->Title); ?> — <?php echo e($event->StartDateTime?->format('M d, Y')); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <div class="flex gap-3 mt-6">
            <button type="submit" class="btn btn-gold">Save Group</button>
            <a href="<?php echo e(route('admin.groups.index')); ?>" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.Layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views/admin/People/Groups/create.blade.php ENDPATH**/ ?>