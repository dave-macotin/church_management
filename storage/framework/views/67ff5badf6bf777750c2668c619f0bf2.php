<?php $__env->startSection('title', 'Donations'); ?>

<?php $__env->startSection('content'); ?>


<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-cinzel text-xl font-semibold" style="color:var(--gold)">Donations</h1>
        <p class="text-sm mt-0.5" style="color:var(--text-muted)">Track and manage all church donations</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="<?php echo e(route('admin.donations.archived')); ?>" class="btn btn-ghost" style="font-size:0.8rem">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="width:14px;height:14px;margin-right:4px"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
            Archived
        </a>
        <a href="<?php echo e(route('admin.donations.create')); ?>" class="btn btn-gold">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Record Donation
        </a>
    </div>
</div>


<?php if(session('success')): ?>
    <div class="mb-4 p-3 rounded" style="background:rgba(93,202,165,0.15);border:1px solid rgba(93,202,165,0.3);color:#5DCAA5;font-size:0.875rem">
        ✓ <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>


<div class="grid grid-cols-1 gap-4 mb-6" style="max-width:280px">
    <div class="card p-4 flex items-center gap-4">
        <div style="color:var(--gold);opacity:0.8">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:32px;height:32px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <div class="text-xs mb-0.5" style="color:var(--text-muted);text-transform:uppercase;letter-spacing:0.08em">Total Donations</div>
            <div class="font-cinzel text-lg font-semibold" style="color:var(--gold)">₱<?php echo e(number_format($total, 2)); ?></div>
        </div>
    </div>
</div>


<form method="GET" action="<?php echo e(route('admin.donations.index')); ?>" class="mb-4">
    <div class="search-wrap" style="max-width:360px">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
        <input type="text" name="search" class="form-input" placeholder="Search by member name or fund category…"
               value="<?php echo e(request('search')); ?>">
    </div>
</form>


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
                                        <span style="display:inline-flex;align-items:center;gap:6px;color:var(--text-muted);font-style:italic;">
                                            <span style="width:7px;height:7px;background:var(--text-muted);border-radius:50%;display:inline-block;opacity:0.5"></span>
                                            Anonymous
                                        </span>
                                    <?php else: ?>
                                        <span style="display:inline-flex;align-items:center;gap:6px;">
                                            <span style="width:7px;height:7px;background:var(--gold);border-radius:50%;display:inline-block"></span>
                                            <?php echo e($member->FirstName); ?> <?php echo e($member->LastName); ?>

                                        </span>
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
                        <td style="text-align:right">
                            <form action="<?php echo e(route('admin.donations.destroy', $donation)); ?>"
                                  method="POST"
                                  onsubmit="return confirm('Archive this donation? It can be restored later.')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-ghost"
                                        style="padding:0.35rem 0.75rem;font-size:0.8rem;color:var(--red)">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                         style="width:13px;height:13px;margin-right:4px;vertical-align:middle">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
                                    </svg>
                                    Archive
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" style="text-align:center;padding:2.5rem;color:var(--text-muted)">
                            No donations recorded yet.
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

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\admin\Finance\Donations\index.blade.php ENDPATH**/ ?>