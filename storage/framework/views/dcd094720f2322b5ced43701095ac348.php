<?php $__env->startSection('title', 'Edit Event — Grace Church CMS'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-center gap-3 mb-6">
    <a href="<?php echo e(route('admin.events.index')); ?>" class="btn btn-ghost" style="padding:0.4rem 0.75rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
    </a>
    <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Edit Event</h1>
</div>

<div class="card p-6 max-w-xl">
    <?php if($errors->any()): ?>
        <div class="alert-error mb-4">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p class="text-sm"><?php echo e($error); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
    <form method="POST" action="<?php echo e(route('admin.events.update', $event)); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
        <div class="flex flex-col gap-4">
            <div>
                <label class="form-label">Title <span style="color:var(--red)">*</span></label>
                <input type="text" name="Title" value="<?php echo e(old('Title', $event->Title)); ?>" class="form-input" required>
            </div>
            <div>
                <label class="form-label">Location</label>
                <input type="text" name="Location" value="<?php echo e(old('Location', $event->Location)); ?>" class="form-input">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Start Date & Time <span style="color:var(--red)">*</span></label>
                    <input type="datetime-local" name="StartDateTime"
                           value="<?php echo e(old('StartDateTime', $event->StartDateTime?->format('Y-m-d\TH:i'))); ?>"
                           class="form-input" required>
                </div>
                <div>
                    <label class="form-label">End Date & Time</label>
                    <input type="datetime-local" name="EndDateTime"
                           value="<?php echo e(old('EndDateTime', $event->EndDateTime?->format('Y-m-d\TH:i'))); ?>"
                           class="form-input">
                </div>
            </div>
            <div>
                <label class="form-label">Event Banner / Photo</label>
                <?php if($event->image): ?>
                    <div class="mb-2">
                        <img src="<?php echo e(asset('storage/'.$event->image)); ?>" alt="Current banner"
                             style="max-height:140px;border-radius:6px;border:1px solid var(--border)">
                        <p class="text-xs mt-1" style="color:var(--text-muted)">Current image — upload a new one to replace it</p>
                    </div>
                <?php endif; ?>
                <input type="file" name="image" accept="image/*" class="form-input" style="padding:0.4rem 0.85rem">
                <p class="text-xs mt-1" style="color:var(--text-muted)">JPG, PNG or GIF — max 2 MB</p>
            </div>
            <?php if(auth()->user()->role === 'admin'): ?>
            <div class="flex items-center gap-3">
                <input type="hidden" name="is_approved" value="0">
                <input type="checkbox" name="is_approved" value="1" id="is_approved"
                       <?php echo e(old('is_approved', $event->is_approved ? '1' : '0') == '1' ? 'checked' : ''); ?>

                       style="width:16px;height:16px;accent-color:var(--gold)">
                <label for="is_approved" class="form-label" style="margin:0">Approved (visible to members)</label>
            </div>
            <?php endif; ?>
        </div>
        <div class="flex gap-3 mt-6">
            <button type="submit" class="btn btn-gold">Update Event</button>
            <a href="<?php echo e(route('admin.events.index')); ?>" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.Layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\admin\Ministry\Events\edit.blade.php ENDPATH**/ ?>