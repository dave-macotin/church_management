<?php $__env->startSection('title', 'My Family'); ?>
<?php $__env->startSection('page_title', 'My Family'); ?>

<?php $__env->startSection('content'); ?>
<?php if($family): ?>
<div style="max-width:900px; margin:0 auto;">
    
    <div class="card" style="padding:40px; margin-bottom:32px; background:linear-gradient(135deg, #221208 0%, #2a160a 100%);">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:32px;">
            <div>
                <div style="color:var(--gold-muted); font-size:11px; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:8px;">Family Profile</div>
                <h2 style="font-family:Georgia, serif; font-size:32px; color:var(--gold-mid); margin-bottom:8px;">The <?php echo e($family->FamilyName); ?> Family</h2>
                <div style="display:flex; align-items:center; gap:12px; color:var(--gold-muted); font-size:14px;">
                    <span style="display:flex; align-items:center; gap:6px;">
                        <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/></svg>
                        <?php echo e($family->HomeAddress ?? 'No address recorded'); ?>

                    </span>
                    <?php if($family->PhoneNumber): ?>
                    <span style="width:4px; height:4px; border-radius:50%; background:var(--border);"></span>
                    <span style="display:flex; align-items:center; gap:6px;">
                        <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-width="2"/></svg>
                        <?php echo e($family->PhoneNumber); ?>

                    </span>
                    <?php endif; ?>
                </div>
            </div>
            <div style="background:var(--accent-glow); padding:12px 24px; border-radius:12px; border:1px solid rgba(216,90,48,0.25); text-align:center;">
                <div style="font-size:24px; font-weight:700; color:var(--gold-bright); font-family:Georgia, serif;"><?php echo e($familyMembers->count()); ?></div>
                <div style="font-size:10px; color:var(--gold-muted); text-transform:uppercase; margin-top:2px;">Members</div>
            </div>
        </div>
    </div>

    <h3 style="font-family:Georgia, serif; font-size:18px; color:var(--gold-muted); margin-bottom:20px; padding-left:4px;">Family Roster</h3>
    
    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr)); gap:20px;">
        <?php $__currentLoopData = $familyMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card" style="padding:20px; display:flex; align-items:center; gap:20px; transition:transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='none'">
            <div style="width:56px; height:56px; border-radius:50%; background:var(--bg-hover); border:2px solid var(--border); display:flex; align-items:center; justify-content:center; color:var(--gold-muted); font-family:Georgia; font-size:20px; font-weight:700; background-size:cover; background-position:center; <?php echo e($member->profile_picture ? 'background-image:url('.asset('storage/'.$member->profile_picture).'); color:transparent;' : ''); ?>">
                <?php echo e(!$member->profile_picture ? strtoupper(substr($member->FirstName, 0, 1)) : ''); ?>

            </div>
            <div style="flex:1;">
                <div style="font-weight:600; color:var(--cream); font-size:15px;"><?php echo e($member->FirstName); ?> <?php echo e($member->LastName); ?></div>
                <div style="font-size:12px; color:var(--gold-muted); margin-top:2px;"><?php echo e($member->role->RoleName ?? 'Member'); ?></div>
                <div style="margin-top:10px;">
                    <span style="font-size:9px; background:<?php echo e($member->Status === 'Active' ? 'var(--green-bg)' : 'var(--red-bg)'); ?>; color:<?php echo e($member->Status === 'Active' ? 'var(--green)' : 'var(--red)'); ?>; padding:2px 8px; border-radius:12px; border:1px solid rgba(200,200,200,0.1);"><?php echo e($member->Status); ?></span>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php else: ?>
<div style="text-align:center; padding:100px 40px; background:var(--bg-card); border-radius:var(--radius); border:1px dashed var(--border); max-width:600px; margin:0 auto;">
    <svg style="width:64px;height:64px;color:var(--gold-muted);margin-bottom:24px;opacity:0.3;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 12l9-9 9 9M4 10v9a1 1 0 001 1h4v-5h4v5h4a1 1 0 001-1V10" stroke-width="1.5"/></svg>
    <div style="color:var(--cream); font-size:18px; font-weight:600; margin-bottom:8px;">No Family Record Found</div>
    <p style="color:var(--gold-muted); font-size:14px; line-height:1.6;">It seems you haven't been linked to a family profile yet. Please visit the church office or coordinate with your group leader to have your family records updated.</p>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('member.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\member\family.blade.php ENDPATH**/ ?>