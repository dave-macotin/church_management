<?php $__env->startSection('title', 'Members — Grace Church Staff'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Members</h1>
        <p class="text-sm mt-1" style="color:var(--text-muted)"><?php echo e($members->total()); ?> registered members</p>
    </div>
    <a href="<?php echo e(route('staff.members.create')); ?>" class="btn btn-gold">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Add Member
    </a>
</div>


<form method="GET" class="flex gap-3 mb-5">
    <div class="search-wrap flex-1">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search by name, email, phone…" class="form-input">
    </div>
    <select name="status" class="form-input" style="width:160px">
        <option value="">All Statuses</option>
        <option value="Active"   <?php echo e(request('status') === 'Active'   ? 'selected' : ''); ?>>Active</option>
        <option value="Inactive" <?php echo e(request('status') === 'Inactive' ? 'selected' : ''); ?>>Inactive</option>
        <option value="Pending"  <?php echo e(request('status') === 'Pending'  ? 'selected' : ''); ?>>Pending</option>
    </select>
    <button type="submit" class="btn btn-ghost">Filter</button>
    <?php if(request('search') || request('status')): ?>
        <a href="<?php echo e(route('staff.members.index')); ?>" class="btn btn-ghost">Clear</a>
    <?php endif; ?>
</form>

<div class="card overflow-hidden">
    <table class="w-full text-left">
        <thead>
            <tr style="background:var(--bg-panel); color:var(--gold-mid); font-size:11px; text-transform:uppercase;">
                <th class="p-4">Name</th>
                <th class="p-4">Email</th>
                <th class="p-4">Phone</th>
                <th class="p-4">Family</th>
                <th class="p-4">Status</th>
                <th class="p-4">Joined</th>
                <th class="p-4"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
        <?php $__empty_1 = true; $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"
                             style="background:var(--bg-hover);color:var(--gold)">
                            <?php echo e(strtoupper(substr($member->FirstName, 0, 1) . substr($member->LastName, 0, 1))); ?>

                        </div>
                        <div>
                            <div class="font-semibold"><?php echo e($member->FirstName); ?> <?php echo e($member->LastName); ?></div>
                            <?php if($member->role): ?>
                                <div class="text-xs" style="color:var(--text-muted)"><?php echo e($member->role->RoleName); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
                <td class="p-4" style="color:var(--text-muted)"><?php echo e($member->Email ?? '—'); ?></td>
                <td class="p-4" style="color:var(--text-muted)"><?php echo e($member->PhoneNumber ?? '—'); ?></td>
                <td class="p-4"><?php echo e($member->family?->FamilyName ?? '—'); ?></td>
                <td class="p-4">
                    <?php if($member->Status === 'Active'): ?>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase" style="background:rgba(93,202,165,0.12); color:#5DCAA5;">Active</span>
                    <?php elseif($member->Status === 'Inactive'): ?>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase" style="background:rgba(216,90,48,0.12); color:#D85A30;">Inactive</span>
                    <?php else: ?>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase" style="background:rgba(250,199,117,0.12); color:#FAC775;">Pending</span>
                    <?php endif; ?>
                </td>
                <td class="p-4" style="color:var(--text-muted)"><?php echo e($member->created_at?->format('M d, Y')); ?></td>
                <td class="p-4">
                    <div class="flex items-center gap-2 justify-end">
                        <a href="<?php echo e(route('staff.members.show', $member)); ?>" class="btn btn-ghost" style="padding:0.35rem 0.7rem;font-size:0.8rem">View</a>
                        <a href="<?php echo e(route('staff.members.edit', $member)); ?>" class="btn btn-ghost" style="padding:0.35rem 0.7rem;font-size:0.8rem">Edit</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" class="text-center py-12" style="color:var(--text-muted)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" style="width:40px;height:40px;margin:0 auto 0.75rem;opacity:0.4"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    No members found
                </td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="flex justify-end mt-4 pagination">
    <?php echo e($members->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('staff.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\staff\members\index.blade.php ENDPATH**/ ?>