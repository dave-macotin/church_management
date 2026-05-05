<?php $__env->startSection('title', 'Archived Donations'); ?>

<?php $__env->startSection('content'); ?>

<div class="flex items-center gap-3 mb-6">
    <a href="<?php echo e(route('admin.donations.index')); ?>" class="btn btn-ghost" style="padding:0.4rem 0.8rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        Back to Donations
    </a>
    <div>
        <h1 class="font-cinzel text-xl font-semibold" style="color:var(--gold)">Archived Donations</h1>
        <p class="text-sm" style="color:var(--text-muted)">Soft-deleted donation records — restore if needed</p>
    </div>
</div>

<?php if(session('success')): ?>
    <div class="mb-4 p-3 rounded" style="background:rgba(93,202,165,0.15);border:1px solid rgba(93,202,165,0.3);color:#5DCAA5;font-size:0.875rem">
        ✓ <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<div class="card">
    <div class="overflow-x-auto">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Donor</th>
                    <th>Fund Category</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Archived On</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $donations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td style="color:var(--text-muted)"><?php echo e($donation->DonationID); ?></td>
                        <td>
                            <?php if($donation->members->isNotEmpty()): ?>
                                <?php $__currentLoopData = $donation->members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($member->pivot->is_anonymous): ?>
                                        <span style="color:var(--text-muted);font-style:italic">Anonymous</span>
                                    <?php else: ?>
                                        <?php echo e($member->FirstName); ?> <?php echo e($member->LastName); ?>

                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <span style="color:var(--text-muted);font-style:italic">Unknown</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($donation->FundCategory ?? '—'); ?></td>
                        <td style="color:var(--gold)">₱<?php echo e(number_format($donation->Amount, 2)); ?></td>
                        <td style="color:var(--text-muted)">
                            <?php echo e($donation->Date ? $donation->Date->format('M d, Y') : '—'); ?>

                        </td>
                        <td style="color:var(--text-muted);font-size:0.8rem">
                            <?php echo e($donation->deleted_at ? $donation->deleted_at->format('M d, Y') : '—'); ?>

                        </td>
                        <td style="text-align:right">
                            <form action="<?php echo e(route('admin.donations.restore', $donation->DonationID)); ?>"
                                  method="POST"
                                  onsubmit="return confirm('Restore this donation?')">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-gold"
                                        style="padding:0.35rem 0.75rem;font-size:0.8rem">
                                    Restore
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" style="text-align:center;padding:2.5rem;color:var(--text-muted)">
                            No archived donations.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if($donations->hasPages()): ?>
    <div class="flex gap-1 mt-4 pagination">
        <?php echo e($donations->links()); ?>

    </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\admin\Finance\Donations\archived.blade.php ENDPATH**/ ?>