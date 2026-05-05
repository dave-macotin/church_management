<?php $__env->startSection('title', 'Expenses'); ?>

<?php $__env->startSection('content'); ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-cinzel text-xl font-semibold" style="color:var(--gold)">Expenses</h1>
        <p class="text-sm mt-0.5" style="color:var(--text-muted)">Track church expenditures</p>
    </div>
    <a href="<?php echo e(route('admin.expenses.create')); ?>" class="btn btn-gold">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Add Expense
    </a>
</div>

<div class="grid grid-cols-1 gap-4 mb-6" style="max-width:280px">
    <div class="card p-4 flex items-center gap-4">
        <div style="color:var(--gold);opacity:0.8">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:32px;height:32px"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
        </div>
        <div>
            <div class="text-xs mb-0.5" style="color:var(--text-muted);text-transform:uppercase;letter-spacing:0.08em">Total Expenses</div>
            <div class="font-cinzel text-lg font-semibold" style="color:var(--gold)">₱<?php echo e(number_format($total, 2)); ?></div>
        </div>
    </div>
</div>

<form method="GET" action="<?php echo e(route('admin.expenses.index')); ?>" class="mb-4">
    <div class="search-wrap" style="max-width:320px">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
        <input type="text" name="search" class="form-input" placeholder="Search category or vendor…"
               value="<?php echo e(request('search')); ?>">
    </div>
</form>

<div class="card">
    <div class="overflow-x-auto">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Category</th>
                    <th>Vendor</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td style="color:var(--text-muted)"><?php echo e($expense->ExpenseID); ?></td>
                        <td><?php echo e($expense->Category ?? '—'); ?></td>
                        <td><?php echo e($expense->Vendor ?? '—'); ?></td>
                        <td style="color:var(--gold)">₱<?php echo e(number_format($expense->Amount, 2)); ?></td>
                        <td style="color:var(--text-muted)">
                            <?php echo e($expense->created_at ? $expense->created_at->format('M d, Y') : '—'); ?>

                        </td>
                        <td style="text-align:right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="<?php echo e(route('admin.expenses.edit', $expense)); ?>" class="btn btn-ghost" style="padding:0.35rem 0.75rem;font-size:0.8rem">
                                    Edit
                                </a>
                                <form action="<?php echo e(route('admin.expenses.destroy', $expense)); ?>"
                                      method="POST" onsubmit="return confirm('Delete this expense?')">
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
                            No expenses recorded yet.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if($expenses->hasPages()): ?>
    <div class="flex gap-1 mt-4 pagination">
        <?php echo e($expenses->links()); ?>

    </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\admin\Finance\Expenses\index.blade.php ENDPATH**/ ?>