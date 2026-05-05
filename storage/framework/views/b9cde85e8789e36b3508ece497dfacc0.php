<?php $__env->startSection('title', 'Edit Asset'); ?>

<?php $__env->startSection('content'); ?>

<div class="flex items-center gap-3 mb-6">
    <a href="<?php echo e(route('admin.assets.index')); ?>" class="btn btn-ghost" style="padding:0.4rem 0.8rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        Back
    </a>
    <div>
        <h1 class="font-cinzel text-xl font-semibold" style="color:var(--gold)">Edit Asset</h1>
        <p class="text-sm" style="color:var(--text-muted)">Update asset #<?php echo e($asset->AssetID); ?></p>
    </div>
</div>

<div class="card p-6" style="max-width:520px">
    <form action="<?php echo e(route('admin.assets.update', $asset)); ?>" method="POST">
        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>

        <div class="mb-4">
            <label class="form-label">Item Name *</label>
            <input type="text" name="ItemName" class="form-input"
                   value="<?php echo e(old('ItemName', $asset->ItemName)); ?>" required>
            <?php $__errorArgs = ['ItemName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-xs mt-1" style="color:var(--red)"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-4">
            <label class="form-label">Serial Number</label>
            <input type="text" name="SerialNumber" class="form-input"
                   value="<?php echo e(old('SerialNumber', $asset->SerialNumber)); ?>">
            <?php $__errorArgs = ['SerialNumber'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-xs mt-1" style="color:var(--red)"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-4">
            <label class="form-label">Purchase Date</label>
            <input type="date" name="PurchaseDate" class="form-input"
                   value="<?php echo e(old('PurchaseDate', optional($asset->PurchaseDate)->format('Y-m-d'))); ?>">
            <?php $__errorArgs = ['PurchaseDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-xs mt-1" style="color:var(--red)"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-6">
            <label class="form-label">Value</label>
            <div class="flex items-center gap-2">
                <span style="color:var(--text-muted);font-size:0.9rem">₱</span>
                <input type="number" step="0.01" min="0" name="Value" class="form-input"
                       value="<?php echo e(old('Value', $asset->Value)); ?>">
            </div>
            <?php $__errorArgs = ['Value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-xs mt-1" style="color:var(--red)"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn btn-gold">Update Asset</button>
            <a href="<?php echo e(route('admin.assets.index')); ?>" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\admin\Finance\Assets\edit.blade.php ENDPATH**/ ?>