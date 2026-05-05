
<?php $__env->startSection('title', 'Groups — Grace Church CMS'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Groups</h1>
        <p class="text-sm mt-1" style="color:var(--text-muted)"><?php echo e($groups->total()); ?> groups</p>
    </div>
    <a href="<?php echo e(route('admin.groups.create')); ?>" class="btn btn-gold">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Add Group
    </a>
</div>

<form method="GET" class="flex gap-3 mb-5">
    <div class="search-wrap flex-1">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search groups…" class="form-input">
    </div>
    <button type="submit" class="btn btn-ghost">Filter</button>
    <?php if(request('search')): ?>
        <a href="<?php echo e(route('admin.groups.index')); ?>" class="btn btn-ghost">Clear</a>
    <?php endif; ?>
</form>

<div class="card overflow-hidden">
    <div class="data-table-container">
        <table>
            <thead>
                <tr>
                    <th>Group Name</th>
                    <th>Description</th>
                    <th>Linked Event</th>
                    <th>Created</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="font-medium text-gold-mid"><?php echo e($group->GroupName); ?></td>
                    <td style="color:var(--gold-muted);max-width:280px">
                        <?php echo e($group->Description ? Str::limit($group->Description, 80) : '—'); ?>

                    </td>
                    <td>
                        <?php if($group->event): ?>
                            <span class="badge badge-blue"><?php echo e($group->event->Title); ?></span>
                        <?php else: ?>
                            <span class="text-xs text-muted">—</span>
                        <?php endif; ?>
                    </td>
                    <td style="color:var(--gold-muted)"><?php echo e($group->created_at?->format('M d, Y')); ?></td>
                    <td>
                        <div class="flex items-center gap-2 justify-end">
                            <a href="<?php echo e(route('admin.groups.edit', $group)); ?>" class="btn btn-ghost btn-sm">Edit</a>
                            <form method="POST" action="<?php echo e(route('admin.groups.destroy', $group)); ?>"
                                  onsubmit="return confirm('Delete <?php echo e($group->GroupName); ?>?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.998 5.998 0 00-1.261-3.606M12 18a4.5 4.5 0 01-4.5-4.5V13.5a4.5 4.5 0 119 0v.003c0 .356-.041.703-.119 1.034m-3.381 3.463L12 18m0 0l-3 3"/>
                            </svg>
                            <h4>No Groups Found</h4>
                            <p>You haven't created any groups yet.</p>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="flex justify-end mt-4 pagination"><?php echo e($groups->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.Layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views/admin/People/Groups/index.blade.php ENDPATH**/ ?>