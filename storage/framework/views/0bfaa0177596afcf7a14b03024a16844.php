
<?php $__env->startSection('title', 'Edit Member — Grace Church CMS'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-center gap-3 mb-6">
    <a href="<?php echo e(route('admin.members.index')); ?>" class="btn btn-ghost" style="padding:0.4rem 0.75rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
    </a>
    <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Edit Member</h1>
</div>

<div class="card p-6 max-w-2xl">
    <?php if($errors->any()): ?>
        <div class="alert-error mb-4">
            <ul class="list-disc list-inside text-sm">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('admin.members.update', $member)); ?>">
        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">First Name <span style="color:var(--red)">*</span></label>
                <input type="text" name="FirstName" value="<?php echo e(old('FirstName', $member->FirstName)); ?>" class="form-input" required>
            </div>
            <div>
                <label class="form-label">Last Name <span style="color:var(--red)">*</span></label>
                <input type="text" name="LastName" value="<?php echo e(old('LastName', $member->LastName)); ?>" class="form-input" required>
            </div>
            <div>
                <label class="form-label">Email</label>
                <input type="email" name="Email" value="<?php echo e(old('Email', $member->Email)); ?>" class="form-input">
            </div>
            <div>
                <label class="form-label">Phone Number</label>
                <input type="text" name="PhoneNumber" value="<?php echo e(old('PhoneNumber', $member->PhoneNumber)); ?>" class="form-input">
            </div>
            <div>
                <label class="form-label">Status <span style="color:var(--red)">*</span></label>
                <select name="Status" class="form-input" required>
                    <option value="Active"   <?php echo e(old('Status', $member->Status) === 'Active'   ? 'selected' : ''); ?>>Active</option>
                    <option value="Inactive" <?php echo e(old('Status', $member->Status) === 'Inactive' ? 'selected' : ''); ?>>Inactive</option>
                    <option value="Pending"  <?php echo e(old('Status', $member->Status) === 'Pending'  ? 'selected' : ''); ?>>Pending</option>
                </select>
            </div>
            <div>
                <label class="form-label">Family</label>
                <select name="FamilyID" class="form-input">
                    <option value="">— None —</option>
                    <?php $__currentLoopData = $families; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $family): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($family->FamilyID); ?>" <?php echo e(old('FamilyID', $member->FamilyID) == $family->FamilyID ? 'selected' : ''); ?>>
                            <?php echo e($family->FamilyName); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label class="form-label">Role</label>
                <select name="RoleID" class="form-input">
                    <option value="">— None —</option>
                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($role->RoleID); ?>" <?php echo e(old('RoleID', $member->RoleID) == $role->RoleID ? 'selected' : ''); ?>>
                            <?php echo e($role->RoleName); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label class="form-label">New Password</label>
                <input type="password" name="Password" class="form-input" placeholder="Leave blank to keep current">
            </div>
        </div>

        <div class="flex gap-3 mt-6">
            <button type="submit" class="btn btn-gold">Update Member</button>
            <a href="<?php echo e(route('admin.members.index')); ?>" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.Layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\admin\People\Members\edit.blade.php ENDPATH**/ ?>