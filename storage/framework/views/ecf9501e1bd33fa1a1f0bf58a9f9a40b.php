<?php $__env->startSection('title', 'My Family'); ?>
<?php $__env->startSection('page_title', 'My Family'); ?>

<?php $__env->startSection('content'); ?>
<?php if($family): ?>
<div class="max-w-4xl mx-auto">
    
    <div class="card p-8 mb-10 bg-gradient-to-br from-gold-bright/10 via-black to-black border-gold-bright/20">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <div class="text-[10px] font-bold text-gold-muted uppercase tracking-[0.2em] mb-2">Family Profile</div>
                <h2 class="font-cinzel text-3xl text-gold-mid mb-3">The <?php echo e($family->FamilyName); ?> Family</h2>
                <div class="flex flex-wrap items-center gap-4 text-sm text-gold-muted/80">
                    <span class="flex items-center gap-2">
                        <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/></svg>
                        <?php echo e($family->HomeAddress ?? 'No address recorded'); ?>

                    </span>
                    <?php if($family->PhoneNumber): ?>
                    <div class="w-1 h-1 rounded-full bg-gold-muted/30"></div>
                    <span class="flex items-center gap-2">
                        <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-width="2"/></svg>
                        <?php echo e($family->PhoneNumber); ?>

                    </span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="bg-gold-bright/5 p-4 rounded-2xl border border-gold-bright/20 text-center min-w-[100px] backdrop-blur-sm">
                <div class="font-cinzel text-3xl font-bold text-gold-bright leading-none"><?php echo e($familyMembers->count()); ?></div>
                <div class="text-[9px] font-bold text-gold-muted uppercase tracking-widest mt-2">Members</div>
            </div>
        </div>
    </div>

    <h3 class="font-cinzel text-lg mb-6 text-gold-muted flex items-center gap-3">
        Family Roster
        <div class="h-px flex-1 bg-white/5"></div>
    </h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <?php $__currentLoopData = $familyMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card p-5 group flex items-center gap-5 transition-all duration-300 hover:border-gold-bright/30">
            <div class="user-avatar btn-sm" style="<?php echo e($member->profile_picture ? 'background-image:url('.asset('storage/'.$member->profile_picture).');' : ''); ?>">
                <?php if(!$member->profile_picture): ?>
                    <?php echo e(strtoupper(substr($member->FirstName, 0, 1))); ?>

                <?php endif; ?>
            </div>
            <div class="flex-1">
                <div class="font-semibold text-cream group-hover:text-gold-bright transition-colors"><?php echo e($member->FirstName); ?> <?php echo e($member->LastName); ?></div>
                <div class="text-[11px] text-gold-muted mt-1 uppercase tracking-wider font-bold">
                    <?php echo e($member->role->RoleName ?? 'Member'); ?>

                </div>
            </div>
            <div class="text-right">
                <span class="badge <?php echo e($member->Status === 'Active' ? 'badge-green' : 'badge-red'); ?>"><?php echo e($member->Status); ?></span>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php else: ?>
<div class="max-w-xl mx-auto">
    <div class="empty-state py-20">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M3 12l9-9 9 9M4 10v9a1 1 0 001 1h4v-5h4v5h4a1 1 0 001-1V10"/>
        </svg>
        <h4>No Family Record Linked</h4>
        <p>It seems you haven't been linked to a family profile yet. Please visit the church office or coordinate with your group leader to update your records.</p>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('member.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views/member/family.blade.php ENDPATH**/ ?>