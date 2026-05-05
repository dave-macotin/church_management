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
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="card p-6 flex items-center gap-5 border-l-4 border-l-gold-bright">
        <div class="w-12 h-12 rounded-xl bg-gold-bright/10 flex items-center justify-center text-gold-bright">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:24px;height:24px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <div class="text-[10px] font-bold text-gold-muted uppercase tracking-wider mb-1">Total Donations</div>
            <div class="font-cinzel text-2xl font-bold text-gold-bright">₱<?php echo e(number_format($total, 2)); ?></div>
        </div>
    </div>
</div>


<form method="GET" action="<?php echo e(route('admin.donations.index')); ?>" class="mb-6">
    <div class="search-wrap" style="max-width:400px">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
        <input type="text" name="search" class="form-input" placeholder="Search donor or fund category..."
               value="<?php echo e(request('search')); ?>">
    </div>
</form>


<div class="card overflow-hidden">
    <div class="data-table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Donor</th>
                    <th>Fund Category</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $donations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td style="color:var(--gold-muted)">#<?php echo e($donation->DonationID); ?></td>
                        <td>
                            <?php if($donation->members->isNotEmpty()): ?>
                                <?php $__currentLoopData = $donation->members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($member->pivot->is_anonymous): ?>
                                        <div class="flex items-center gap-2 text-gold-muted italic">
                                            <div class="w-2 h-2 rounded-full bg-gold-muted/30"></div>
                                            Anonymous
                                        </div>
                                    <?php else: ?>
                                        <div class="flex items-center gap-3">
                                            <div class="user-avatar btn-xs" style="<?php echo e($member->profile_picture ? 'background-image:url('.asset('storage/'.$member->profile_picture).');' : ''); ?>">
                                                <?php if(!$member->profile_picture): ?>
                                                    <?php echo e(strtoupper(substr($member->FirstName, 0, 1))); ?>

                                                <?php endif; ?>
                                            </div>
                                            <span class="font-medium text-cream"><?php echo e($member->FirstName); ?> <?php echo e($member->LastName); ?></span>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <span class="text-gold-muted italic">Unknown Donor</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge badge-muted"><?php echo e($donation->FundCategory ?? 'General'); ?></span>
                        </td>
                        <td><span class="font-bold text-gold-bright">₱<?php echo e(number_format($donation->Amount, 2)); ?></span></td>
                        <td style="color:var(--gold-muted)">
                            <?php echo e($donation->Date ? $donation->Date->format('M d, Y') : '—'); ?>

                        </td>
                        <td class="text-right">
                            <form action="<?php echo e(route('admin.donations.destroy', $donation)); ?>"
                                  method="POST"
                                  onsubmit="return confirm('Archive this donation? It can be restored later.')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-ghost btn-sm" style="color:var(--red); border-color:rgba(240, 153, 123, 0.2)">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                         style="width:14px;height:14px;margin-right:6px">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
                                    </svg>
                                    Archive
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <h4>No Donations Recorded</h4>
                                <p>There are no donations matching your current search criteria.</p>
                            </div>
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

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views/admin/Finance/Donations/index.blade.php ENDPATH**/ ?>