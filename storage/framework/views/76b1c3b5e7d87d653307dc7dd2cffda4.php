<?php $__env->startSection('title', 'Assets'); ?>

<?php $__env->startSection('content'); ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-cinzel text-xl font-semibold" style="color:var(--gold)">Assets</h1>
        <p class="text-sm mt-0.5" style="color:var(--text-muted)">Church property and inventory</p>
    </div>
    <a href="<?php echo e(route('admin.assets.create')); ?>" class="btn btn-gold">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Add Asset
    </a>
</div>

<div class="grid grid-cols-1 gap-4 mb-6" style="max-width:280px">
    <div class="card p-4 flex items-center gap-4">
        <div style="color:var(--gold);opacity:0.8">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:32px;height:32px"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
        </div>
        <div>
            <div class="text-xs mb-0.5" style="color:var(--text-muted);text-transform:uppercase;letter-spacing:0.08em">Total Value</div>
            <div class="font-cinzel text-lg font-semibold" style="color:var(--gold)">₱<?php echo e(number_format($totalValue, 2)); ?></div>
        </div>
    </div>
</div>

<form method="GET" action="<?php echo e(route('admin.assets.index')); ?>" class="mb-4">
    <div class="search-wrap" style="max-width:320px">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
        <input type="text" name="search" class="form-input" placeholder="Search item name or serial…"
               value="<?php echo e(request('search')); ?>">
    </div>
</form>

<div class="card">
    <div class="overflow-x-auto">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item Name</th>
                    <th>Serial Number</th>
                    <th>Purchase Date</th>
                    <th>Value</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td style="color:var(--text-muted)"><?php echo e($asset->AssetID); ?></td>
                        <td><?php echo e($asset->ItemName); ?></td>
                        <td style="color:var(--text-muted)"><?php echo e($asset->SerialNumber ?? '—'); ?></td>
                        <td style="color:var(--text-muted)">
                            <?php echo e($asset->PurchaseDate ? $asset->PurchaseDate->format('M d, Y') : '—'); ?>

                        </td>
                        <td style="color:var(--gold)">₱<?php echo e(number_format($asset->Value ?? 0, 2)); ?></td>
                        <td style="text-align:right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="<?php echo e(route('admin.assets.edit', $asset)); ?>" class="btn btn-ghost" style="padding:0.35rem 0.75rem;font-size:0.8rem">
                                    Edit
                                </a>
                                <form action="<?php echo e(route('admin.assets.destroy', $asset)); ?>"
                                      method="POST" onsubmit="return confirm('Delete this asset?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger" style="padding:0.35rem 0.75rem;font-size:0.8rem">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" style="text-align:center;padding:2.5rem;color:var(--text-muted)">
                            No assets recorded yet.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if($assets->hasPages()): ?>
    <div class="flex gap-1 mt-4 pagination">
        <?php echo e($assets->links()); ?>

    </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\admin\Finance\Assets\index.blade.php ENDPATH**/ ?>