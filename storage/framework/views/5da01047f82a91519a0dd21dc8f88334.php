<?php $__env->startSection('title', 'Volunteer Opportunities — ' . App\Models\Setting::get('church_name', 'Grace Church')); ?>
<?php $__env->startSection('page_title', 'Serve the Community'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8 p-8 card bg-gradient-to-br from-bg-card to-bg-hover border-l-4" style="border-left-color: var(--gold)">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Call to Service</h1>
            <p class="text-sm mt-1" style="color:var(--text-muted)">"Each of you should use whatever gift you have received to serve others..." — 1 Peter 4:10</p>
        </div>
        <div class="flex gap-4">
            <div class="text-center">
                <div class="text-2xl font-cinzel text-main"><?php echo e(count($opportunities)); ?></div>
                <div class="text-[10px] uppercase font-bold text-muted">Open Roles</div>
            </div>
            <div class="border-r border-white/10"></div>
            <div class="text-center">
                <div class="text-2xl font-cinzel text-main"><?php echo e(count($myRegistrations)); ?></div>
                <div class="text-[10px] uppercase font-bold text-muted">My Signups</div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php $__empty_1 = true; $__currentLoopData = $opportunities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="card p-6 flex flex-col h-full border-t-2 <?php echo e(in_array($opp->id, $myRegistrations) ? 'border-green-500' : 'border-gold/30'); ?>">
            <div class="flex justify-between items-start mb-4">
                <div class="px-2 py-1 rounded bg-gold/10 border border-gold/20 text-[10px] font-bold uppercase text-gold">
                    <?php echo e($opp->category ?? 'General'); ?>

                </div>
                <?php if(in_array($opp->id, $myRegistrations)): ?>
                    <div class="px-2 py-1 rounded bg-green-500/10 border border-green-500/40 text-[10px] font-bold uppercase text-green-500">
                        Signed Up
                    </div>
                <?php endif; ?>
            </div>

            <h3 class="font-cinzel text-lg mb-2" style="color:var(--gold-mid)"><?php echo e($opp->title); ?></h3>
            <p class="text-xs mb-6 flex-1 opacity-70 leading-relaxed"><?php echo e($opp->description); ?></p>

            <div class="space-y-2 mb-6 text-xs" style="color:var(--text-muted)">
                <div class="flex justify-between">
                    <span>Date:</span>
                    <span class="text-main font-semibold"><?php echo e($opp->date ? \Carbon\Carbon::parse($opp->date)->format('M d, Y') : 'Ongoing'); ?></span>
                </div>
                <div class="flex justify-between">
                    <span>Shift:</span>
                    <span class="text-main font-semibold"><?php echo e($opp->time_slot ?? 'Flexible'); ?></span>
                </div>
                <div class="flex justify-between">
                    <span>Positions:</span>
                    <span class="text-main font-semibold text-gold"><?php echo e($opp->needed_volunteers); ?> needed</span>
                </div>
            </div>

            <?php if(!in_array($opp->id, $myRegistrations)): ?>
                <form method="POST" action="<?php echo e(route('member.volunteering.signup', $opp->id)); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-gold w-full py-2.5 h-auto text-xs uppercase font-bold tracking-widest">Sign Up to Serve</button>
                </form>
            <?php else: ?>
                <button disabled class="btn btn-ghost w-full py-2.5 h-auto text-xs uppercase font-bold tracking-widest opacity-50 cursor-not-allowed">Application Pending</button>
            <?php endif; ?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full py-20 text-center card">
            <div class="text-5xl mb-4 opacity-20">🤝</div>
            <p style="color:var(--gold-muted)">No active volunteer opportunities at the moment.</p>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('member.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\member\volunteering\index.blade.php ENDPATH**/ ?>