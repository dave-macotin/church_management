<?php $__env->startSection('title', 'Record Donation'); ?>

<?php $__env->startSection('content'); ?>

<div class="flex items-center gap-3 mb-6">
    <a href="<?php echo e(route('admin.donations.index')); ?>" class="btn btn-ghost" style="padding:0.4rem 0.8rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        Back
    </a>
    <div>
        <h1 class="font-cinzel text-xl font-semibold" style="color:var(--gold)">Record Donation</h1>
        <p class="text-sm" style="color:var(--text-muted)">Add a new donation and link it to an existing member</p>
    </div>
</div>

<div class="card p-6" style="max-width:560px">
    <form action="<?php echo e(route('admin.donations.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        
        <div class="mb-4">
            <label class="form-label">Donor (Member) *</label>
            <select name="MemberID" class="form-input <?php $__errorArgs = ['MemberID'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                <option value="">— Select a member —</option>
                <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($member->MemberID); ?>"
                        <?php echo e(old('MemberID') == $member->MemberID ? 'selected' : ''); ?>>
                        <?php echo e($member->LastName); ?>, <?php echo e($member->FirstName); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['MemberID'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-xs mt-1" style="color:var(--red)"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <?php if($members->isEmpty()): ?>
                <p class="text-xs mt-1" style="color:var(--red)">
                    No members found. Please add members first before recording a donation.
                </p>
            <?php endif; ?>
        </div>

        
        <div class="mb-4">
            <label class="form-label">Amount *</label>
            <div class="flex items-center gap-2">
                <span style="color:var(--text-muted);font-size:0.9rem">₱</span>
                <input type="number" step="0.01" min="1" name="Amount"
                       class="form-input <?php $__errorArgs = ['Amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       value="<?php echo e(old('Amount')); ?>" required placeholder="0.00">
            </div>
            <?php $__errorArgs = ['Amount'];
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
            <label class="form-label">Date *</label>
            <input type="date" name="Date"
                   class="form-input <?php $__errorArgs = ['Date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   value="<?php echo e(old('Date', date('Y-m-d'))); ?>" required>
            <?php $__errorArgs = ['Date'];
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
            <label class="form-label">Fund Category *</label>
            <select name="FundCategory" class="form-input <?php $__errorArgs = ['FundCategory'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                <option value="">— Select a category —</option>
                <?php $__currentLoopData = ['Tithe','Offering','Mission','Building Fund','Special','Other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($cat); ?>" <?php echo e(old('FundCategory') === $cat ? 'selected' : ''); ?>>
                        <?php echo e($cat); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['FundCategory'];
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
            <button type="submit" class="btn btn-gold">Save Donation</button>
            <a href="<?php echo e(route('admin.donations.index')); ?>" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\admin\Finance\Donations\create.blade.php ENDPATH**/ ?>