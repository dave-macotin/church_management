<?php $__env->startSection('title', 'Add Expense — Grace Church CMS'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-center gap-3 mb-6">
    <a href="<?php echo e(route('admin.expenses.index')); ?>" class="btn btn-ghost" style="padding:0.4rem 0.75rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
    </a>
    <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Add Expense</h1>
</div>

<div class="card p-6 max-w-xl">
    <?php if($errors->any()): ?>
        <div class="alert-error mb-4">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p class="text-sm"><?php echo e($error); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
    <form method="POST" action="<?php echo e(route('admin.expenses.store')); ?>">
        <?php echo csrf_field(); ?>
        <div class="flex flex-col gap-4">
            <div>
                <label class="form-label">Category</label>
                <input type="text" name="Category" value="<?php echo e(old('Category')); ?>" class="form-input" placeholder="e.g. Sound System, Catering">
            </div>
            <div>
                <label class="form-label">Amount <span style="color:var(--red)">*</span></label>
                <input type="number" step="0.01" name="Amount" value="<?php echo e(old('Amount')); ?>" class="form-input" required min="0">
            </div>
            <div>
                <label class="form-label">Vendor / Payee</label>
                <input type="text" name="Vendor" value="<?php echo e(old('Vendor')); ?>" class="form-input">
            </div>
            <div>
                <label class="form-label">For Event (optional)</label>
                <select name="EventID" class="form-input">
                    <option value="">— General / Not Event-Specific —</option>
                    <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($event->EventID); ?>" <?php echo e(old('EventID') == $event->EventID ? 'selected' : ''); ?>>
                            <?php echo e($event->Title); ?> — <?php echo e($event->StartDateTime?->format('M d, Y')); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <p class="text-xs mt-1" style="color:var(--text-muted)">Link this expense to a specific approved event funded by donations.</p>
            </div>
        </div>
        <div class="flex gap-3 mt-6">
            <button type="submit" class="btn btn-gold">Record Expense</button>
            <a href="<?php echo e(route('admin.expenses.index')); ?>" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.Layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\admin\Finance\Expenses\create.blade.php ENDPATH**/ ?>