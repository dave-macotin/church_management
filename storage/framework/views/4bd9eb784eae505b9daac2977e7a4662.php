<?php $__env->startSection('title', 'Group Details — Grace Church Staff'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-center gap-3 mb-6">
    <a href="<?php echo e(route('staff.groups.index')); ?>" class="btn btn-ghost" style="padding:0.4rem 0.8rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        Back to List
    </a>
    <div>
        <h1 class="font-cinzel text-xl font-semibold" style="color:var(--gold-mid)">Group Details</h1>
        <p class="text-sm" style="color:var(--gold-muted)"><?php echo e($group->GroupName); ?></p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-1 space-y-6">
        <div class="card p-6">
            <h2 class="text-xl font-bold mb-4" style="color:var(--gold-mid)"><?php echo e($group->GroupName); ?></h2>
            <div class="space-y-4">
                <div>
                    <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Description</label>
                    <div class="text-sm"><?php echo e($group->Description ?? 'No description provided'); ?></div>
                </div>
                <div>
                    <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Linked Event</label>
                    <div class="text-sm">
                        <?php if($group->event): ?>
                            <a href="<?php echo e(route('staff.events.show', $group->event)); ?>" class="text-gold hover:underline"><?php echo e($group->event->Title); ?></a>
                        <?php else: ?>
                            No event linked
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="mt-6">
                 <a href="<?php echo e(route('staff.groups.edit', $group)); ?>" class="btn btn-gold w-full text-xs">Edit Group Info</a>
            </div>
        </div>
    </div>

    <div class="md:col-span-2 space-y-6">
        <div class="card overflow-hidden">
            <div class="panel-header">
                <h3 class="panel-title">Group Roles / Assignments</h3>
            </div>
             <table class="w-full text-left">
                <thead>
                    <tr style="background:var(--bg-panel); color:var(--gold-mid); font-size:11px; text-transform:uppercase;">
                        <th class="p-4">Role Name</th>
                        <th class="p-4">Description</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php $__empty_1 = true; $__currentLoopData = $group->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grole): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="p-4 font-medium text-sm"><?php echo e($grole->RoleName); ?></td>
                            <td class="p-4 text-xs text-muted"><?php echo e($grole->Description ?? '—'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="2" class="p-8 text-center text-sm" style="color:var(--gold-muted)">No roles assigned to this group.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('staff.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\staff\groups\show.blade.php ENDPATH**/ ?>