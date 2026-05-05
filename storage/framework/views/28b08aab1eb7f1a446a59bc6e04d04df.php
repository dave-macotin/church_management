<?php $__env->startSection('title', 'Member Details — Grace Church Staff'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-center gap-3 mb-6">
    <a href="<?php echo e(route('staff.members.index')); ?>" class="btn btn-ghost" style="padding:0.4rem 0.8rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        Back to List
    </a>
    <div>
        <h1 class="font-cinzel text-xl font-semibold" style="color:var(--gold-mid)">Member Profile</h1>
        <p class="text-sm" style="color:var(--gold-muted)"><?php echo e($member->FirstName); ?> <?php echo e($member->LastName); ?></p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-1 space-y-6">
        <div class="card p-6 text-center">
            <div class="w-24 h-24 rounded-full mx-auto mb-4 border-2 border-gold flex items-center justify-center text-2xl font-bold bg-panel" style="color:var(--gold)">
                <?php if($member->profile_picture): ?>
                    <img src="<?php echo e(asset('storage/' . $member->profile_picture)); ?>" class="w-full h-full rounded-full object-cover">
                <?php else: ?>
                    <?php echo e(strtoupper(substr($member->FirstName, 0, 1) . substr($member->LastName, 0, 1))); ?>

                <?php endif; ?>
            </div>
            <h2 class="text-xl font-bold" style="color:var(--gold-mid)"><?php echo e($member->FirstName); ?> <?php echo e($member->LastName); ?></h2>
            <p class="text-sm" style="color:var(--gold-muted)"><?php echo e($member->role?->RoleName ?? 'Member'); ?></p>
            
            <div class="mt-4 flex flex-wrap justify-center gap-2">
                <?php if($member->Status === 'Active'): ?>
                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase" style="background:rgba(93,202,165,0.12); color:#5DCAA5;">Active</span>
                <?php else: ?>
                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase" style="background:rgba(216,90,48,0.12); color:#D85A30;"><?php echo e($member->Status); ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="card p-6">
            <h3 class="text-sm font-bold uppercase tracking-wider mb-4" style="color:var(--gold-muted)">Contact Details</h3>
            <div class="space-y-4">
                <div>
                    <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Email</label>
                    <div class="text-sm"><?php echo e($member->Email ?? 'No email provided'); ?></div>
                </div>
                <div>
                    <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Phone</label>
                    <div class="text-sm"><?php echo e($member->PhoneNumber ?? 'No phone provided'); ?></div>
                </div>
                <div>
                    <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Family</label>
                    <div class="text-sm">
                        <?php if($member->family): ?>
                            <a href="<?php echo e(route('staff.families.show', $member->family)); ?>" class="text-gold hover:underline"><?php echo e($member->family->FamilyName); ?></a>
                        <?php else: ?>
                            No family assigned
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="md:col-span-2 space-y-6">
        <div class="card overflow-hidden">
            <div class="panel-header">
                <h3 class="panel-title">Recent Attendance</h3>
            </div>
            <table class="w-full text-left">
                <thead>
                    <tr style="background:var(--bg-panel); color:var(--gold-mid); font-size:11px; text-transform:uppercase;">
                        <th class="p-4">Date</th>
                        <th class="p-4">Event</th>
                        <th class="p-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php $__empty_1 = true; $__currentLoopData = $member->attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="p-4 text-sm"><?php echo e($attendance->Timestamp->format('M d, Y')); ?></td>
                            <td class="p-4 text-sm"><?php echo e($attendance->event?->Title ?? 'General'); ?></td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase" 
                                      style="background:<?php echo e($attendance->Status === 'Present' ? 'rgba(93,202,165,0.12)' : 'rgba(216,90,48,0.12)'); ?>; 
                                             color:<?php echo e($attendance->Status === 'Present' ? '#5DCAA5' : '#D85A30'); ?>;">
                                    <?php echo e($attendance->Status); ?>

                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="3" class="p-8 text-center text-sm" style="color:var(--gold-muted)">No attendance records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('staff.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\staff\members\show.blade.php ENDPATH**/ ?>