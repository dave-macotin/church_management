<?php $__env->startSection('title', 'Families — Grace Church Staff'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Families</h1>
        <p class="text-sm mt-1" style="color:var(--text-muted)"><?php echo e($families->total()); ?> families registered</p>
    </div>
    <a href="<?php echo e(route('staff.families.create')); ?>" class="btn btn-gold">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Add Family
    </a>
</div>

<form method="GET" class="flex gap-3 mb-5">
    <div class="search-wrap flex-1">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search by family name, address…" class="form-input">
    </div>
    <button type="submit" class="btn btn-ghost">Filter</button>
    <?php if(request('search')): ?>
        <a href="<?php echo e(route('staff.families.index')); ?>" class="btn btn-ghost">Clear</a>
    <?php endif; ?>
</form>

<div class="card overflow-hidden">
    <table class="w-full text-left">
        <thead>
            <tr style="background:var(--bg-panel); color:var(--gold-mid); font-size:11px; text-transform:uppercase;">
                <th class="p-4">Family Name</th>
                <th class="p-4">Head of Family</th>
                <th class="p-4">Address</th>
                <th class="p-4">Phone</th>
                <th class="p-4">Members</th>
                <th class="p-4"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
        <?php $__empty_1 = true; $__currentLoopData = $families; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $family): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="p-4 font-semibold"><?php echo e($family->FamilyName); ?></td>
                <td class="p-4"><?php echo e($family->headMember ? $family->headMember->FirstName . ' ' . $family->headMember->LastName : '—'); ?></td>
                <td class="p-4 text-sm" style="color:var(--text-muted)"><?php echo e($family->HomeAddress ?? '—'); ?></td>
                <td class="p-4 text-sm" style="color:var(--text-muted)"><?php echo e($family->PhoneNumber ?? '—'); ?></td>
                <td class="p-4">
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase" style="background:var(--bg-hover); color:var(--gold-muted);"><?php echo e($family->members->count()); ?> Members</span>
                </td>
                <td class="p-4">
                    <div class="flex items-center gap-2 justify-end">
                        <a href="<?php echo e(route('staff.families.show', $family)); ?>" class="btn btn-ghost" style="padding:0.35rem 0.7rem;font-size:0.8rem">View</a>
                        <a href="<?php echo e(route('staff.families.edit', $family)); ?>" class="btn btn-ghost" style="padding:0.35rem 0.7rem;font-size:0.8rem">Edit</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="6" class="text-center py-12" style="color:var(--text-muted)">No families found</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="flex justify-end mt-4 pagination"><?php echo e($families->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('staff.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\staff\families\index.blade.php ENDPATH**/ ?>