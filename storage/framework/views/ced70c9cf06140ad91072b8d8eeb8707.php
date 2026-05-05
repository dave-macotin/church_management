<?php $__env->startSection('title', 'My Groups'); ?>
<?php $__env->startSection('page_title', 'My Groups'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <div class="mb-10 text-center">
        <h3 class="font-cinzel text-2xl text-gold-bright mb-2">Ministry Groups</h3>
        <p class="text-sm text-gold-muted">Connect with your church community. Join groups to stay involved.</p>
    </div>

    <?php if($groups->isEmpty()): ?>
        <div class="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <h4>No Ministry Groups Available</h4>
            <p>New groups will appear here once they are created by the church administration.</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $joined = in_array($group->GroupID, $joinedIds); ?>
            <div class="card p-6 flex flex-col group transition-all duration-300 hover:border-gold-bright/30 <?php echo e($joined ? 'border-gold-bright/20 bg-gold-bright/5' : ''); ?>">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-gold-bright/10 flex items-center justify-center text-gold-bright">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-cinzel text-base font-bold text-gold-mid"><?php echo e($group->GroupName); ?></h4>
                        <?php if($joined): ?>
                            <span class="badge badge-green mt-1">Joined</span>
                        <?php endif; ?>
                    </div>
                </div>

                <p class="text-sm text-cream opacity-70 mb-6 flex-1 line-clamp-3">
                    <?php echo e($group->Description ?? 'Join this group to connect with other members and participate in ministry activities.'); ?>

                </p>

                <div class="mt-auto">
                    <?php if($joined): ?>
                        <form method="POST" action="<?php echo e(route('member.groups.leave', $group->GroupID)); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-ghost w-full py-2.5 text-red-400 border-red-500/20 hover:bg-red-500/5 transition-colors">
                                Leave Group
                            </button>
                        </form>
                    <?php else: ?>
                        <form method="POST" action="<?php echo e(route('member.groups.join', $group->GroupID)); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-gold w-full py-2.5">
                                Join Group
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('member.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views/member/groups.blade.php ENDPATH**/ ?>