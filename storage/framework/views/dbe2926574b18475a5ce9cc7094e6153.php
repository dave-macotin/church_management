<?php $__env->startSection('title', 'My Profile'); ?>
<?php $__env->startSection('page_title', 'My Profile'); ?>

<?php $__env->startSection('extra_css'); ?>
<style>
    .profile-grid { display: grid; grid-template-columns: 300px 1fr; gap: 24px; }
    .avatar-upload { position: relative; width: 180px; height: 180px; margin: 0 auto 20px; }
    .avatar-preview { width: 100%; height: 100%; border-radius: 50%; border: 3px solid var(--border); background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center; background-color: var(--bg-card); overflow: hidden; }
    .avatar-edit { position: absolute; bottom: 5px; right: 5px; width: 36px; height: 36px; border-radius: 50%; background: var(--gold-bright); color: #000; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 3px solid var(--bg-panel); transition: transform 0.2s; }
    .avatar-edit:hover { transform: scale(1.1); }
    .info-group { margin-bottom: 20px; }
    .info-label { font-size: 11px; color: var(--gold-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; }
    .info-value { font-size: 15px; color: var(--cream); font-weight: 500; }
    @media (max-width: 860px) { .profile-grid { grid-template-columns: 1fr; } }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php
    $dashRoute = match(auth()->user()->role) {
        'admin'  => 'admin.dashboard',
        'staff'  => 'staff.dashboard',
        default  => 'member.dashboard',
    };
?>

<div class="flex items-center gap-3 mb-6">
    <a href="<?php echo e(route($dashRoute)); ?>" class="btn btn-ghost" style="padding:0.4rem 0.8rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        Back to Dashboard
    </a>
    <div>
        <h1 class="font-cinzel text-xl font-semibold" style="color:var(--gold-mid)">My Profile</h1>
        <p class="text-sm" style="color:var(--text-muted)">Manage your account and personal details</p>
    </div>
</div>

<div class="profile-grid">
    
    <div style="display:flex; flex-direction:column; gap:24px;">
        <div class="card" style="padding:32px 24px; text-align:center;">
            <form action="<?php echo e(route('profile.update')); ?>" method="POST" id="avatarForm" enctype="multipart/form-data">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                <div class="avatar-upload">
                    <?php $profilePic = $member ? $member->profile_picture : null; ?>
                    <div class="avatar-preview" id="imagePreview" style="<?php echo e($profilePic ? 'background-image:url('.asset('storage/'.$profilePic).');' : ''); ?>">
                        <?php if(!$profilePic): ?>
                            <span style="font-size:64px; font-family:Georgia, serif; color:var(--gold-muted);"><?php echo e(strtoupper(substr($user->name ?? 'A', 0, 1))); ?></span>
                        <?php endif; ?>
                    </div>
                    <label for="profile_picture" class="avatar-edit">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <input type="file" name="profile_picture" id="profile_picture" style="display:none;" onchange="this.form.submit()">
                    </label>
                </div>
            </form>
            <h2 style="font-family:Georgia, serif; font-size:22px; color:var(--gold-mid); margin-bottom:4px;"><?php echo e($user->name); ?></h2>
            <div style="font-size:12px; color:var(--gold-muted); margin-bottom:12px;"><?php echo e(ucfirst($user->role)); ?> Account</div>
            <div style="display:flex; justify-content:center; gap:8px;">
                <span style="background:var(--accent-glow); color:var(--gold-bright); font-size:10px; padding:4px 10px; border-radius:99px; border:1px solid rgba(216,90,48,0.2);"><?php echo e(mb_strtoupper($user->role)); ?></span>
            </div>
        </div>

        <div class="card" style="padding:20px;">
            <div class="info-group">
                <div class="info-label">Account Created</div>
                <div class="info-value"><?php echo e($user->created_at?->format('F d, Y') ?? 'N/A'); ?></div>
            </div>
            <div class="info-group" style="margin-bottom:0;">
                <div class="info-label">Email</div>
                <div class="info-value"><?php echo e($user->email); ?></div>
            </div>
        </div>
    </div>

    
    <div style="display:flex; flex-direction:column; gap:24px;">
        <div class="card" style="padding:32px;">
            <h3 style="font-family:Georgia, serif; font-size:18px; color:var(--gold-mid); margin-bottom:24px; display:flex; align-items:center; gap:10px;">
                <svg style="width:18px;height:18px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Personal Information
            </h3>

            <form action="<?php echo e(route('profile.update')); ?>" method="POST">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                
                <div style="margin-bottom:24px;">
                    <label class="info-label">Display Name *</label>
                    <input type="text" name="name" class="form-input <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('name', $user->name)); ?>" required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color:var(--red); font-size:11px;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div style="margin-bottom:24px;">
                    <label class="info-label">Email Address *</label>
                    <input type="email" name="email" class="form-input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('email', $user->email)); ?>" required>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color:var(--red); font-size:11px;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <?php if($member): ?>
                    <hr style="border-color:var(--border-soft); margin:24px 0;">
                    <h3 style="font-family:Georgia, serif; font-size:14px; color:var(--gold-muted); margin-bottom:24px; text-transform:uppercase; letter-spacing:0.05em;">Member Details</h3>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:24px;">
                        <div>
                            <label class="info-label">First Name</label>
                            <input type="text" name="first_name" class="form-input" value="<?php echo e(old('first_name', $member->FirstName)); ?>">
                            <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color:var(--red); font-size:11px;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div>
                            <label class="info-label">Last Name</label>
                            <input type="text" name="last_name" class="form-input" value="<?php echo e(old('last_name', $member->LastName)); ?>">
                            <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color:var(--red); font-size:11px;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div style="margin-bottom:24px;">
                        <label class="info-label">Phone Number</label>
                        <input type="text" name="phone_number" class="form-input" value="<?php echo e(old('phone_number', $member->PhoneNumber)); ?>">
                        <?php $__errorArgs = ['phone_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color:var(--red); font-size:11px;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div style="margin-bottom:32px;">
                        <label class="info-label">Date of Birth</label>
                        <input type="date" name="date_of_birth" class="form-input" value="<?php echo e(old('date_of_birth', optional($member->DateOfBirth)->format('Y-m-d'))); ?>">
                        <?php $__errorArgs = ['date_of_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color:var(--red); font-size:11px;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                <?php endif; ?>

                <div style="display:flex; justify-content:flex-end; gap:12px;">
                    <button type="submit" class="btn btn-gold">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        
        <div class="card" style="padding:32px;">
            <h3 style="font-family:Georgia, serif; font-size:18px; color:var(--red); margin-bottom:24px; display:flex; align-items:center; gap:10px;">
                <svg style="width:18px;height:18px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Change Password
            </h3>

            <form action="<?php echo e(route('profile.password')); ?>" method="POST">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                
                <div style="margin-bottom:24px;">
                    <label class="info-label">Current Password *</label>
                    <input type="password" name="current_password" class="form-input <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                    <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color:var(--red); font-size:11px;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div style="margin-bottom:24px;">
                    <label class="info-label">New Password *</label>
                    <input type="password" name="new_password" class="form-input <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                    <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color:var(--red); font-size:11px;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div style="margin-bottom:32px;">
                    <label class="info-label">Confirm New Password *</label>
                    <input type="password" name="new_password_confirmation" class="form-input" required>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:12px;">
                    <button type="submit" class="btn btn-ghost" style="color:var(--red); border-color:var(--red);">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\profile\edit.blade.php ENDPATH**/ ?>