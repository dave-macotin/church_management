
<?php $__env->startSection('title', 'System Users — Grace Church CMS'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-cinzel text-2xl" style="color:var(--gold)">System Users</h1>
        <p class="text-sm mt-1" style="color:var(--text-muted)">Manage admin, staff, and member login accounts</p>
    </div>
</div>


<form method="GET" action="<?php echo e(route('admin.users.index')); ?>" class="flex gap-3 mb-5 flex-wrap">
    <div class="search-wrap" style="flex:1;min-width:200px;max-width:320px">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
        </svg>
        <input type="text" name="search" class="form-input"
               placeholder="Search name or email…"
               value="<?php echo e(request('search')); ?>">
    </div>
    <select name="role" class="form-input" style="width:150px" onchange="this.form.submit()">
        <option value="">All Roles</option>
        <option value="admin"  <?php echo e(request('role') === 'admin'  ? 'selected' : ''); ?>>Admin</option>
        <option value="staff"  <?php echo e(request('role') === 'staff'  ? 'selected' : ''); ?>>Staff</option>
        <option value="member" <?php echo e(request('role') === 'member' ? 'selected' : ''); ?>>Member</option>
    </select>
    <button type="submit" class="btn btn-ghost">Search</button>
    <?php if(request('search') || request('role')): ?>
        <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-ghost">Clear</a>
    <?php endif; ?>
</form>

<div class="card overflow-hidden">
    <div class="data-table-container">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Registered</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="user-avatar" 
                                     style="<?php echo e($user->member?->profile_picture ? 'background-image:url('.asset('storage/'.$user->member->profile_picture).'); color:transparent;' : 'background:var(--bg-hover);color:var(--gold-mid);'); ?>">
                                    <?php if(!$user->member?->profile_picture): ?>
                                        <?php echo e(strtoupper(substr($user->name ?? 'U', 0, 1))); ?>

                                    <?php endif; ?>
                                </div>
                                <span class="font-medium"><?php echo e($user->name); ?></span>
                            </div>
                        </td>
                        <td style="color:var(--gold-muted)"><?php echo e($user->email); ?></td>
                        <td>
                            <?php if($user->role === 'admin'): ?>
                                <span class="badge badge-red">Admin</span>
                            <?php elseif($user->role === 'staff'): ?>
                                <span class="badge badge-amber">Staff</span>
                            <?php else: ?>
                                <span class="badge badge-muted">Member</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($user->is_approved): ?>
                                <span class="badge badge-green">Approved</span>
                            <?php else: ?>
                                <span class="badge badge-amber">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td style="color:var(--gold-muted)">
                            <?php echo e($user->created_at?->format('M d, Y') ?? '—'); ?>

                        </td>
                        <td>
                            <div class="flex items-center gap-2 justify-end">
                                
                                <?php if (! ($user->is_approved)): ?>
                                    <form action="<?php echo e(route('admin.users.approve', $user)); ?>" method="POST">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="btn btn-gold btn-sm">
                                            Approve
                                        </button>
                                    </form>
                                <?php endif; ?>

                                
                                <?php if($user->id !== auth()->id()): ?>
                                    <form action="<?php echo e(route('admin.users.destroy', $user)); ?>" method="POST"
                                          onsubmit="return confirm('Remove <?php echo e(addslashes($user->name)); ?>? This cannot be undone.')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Remove
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-xs" style="color:var(--gold-muted)">(you)</span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                                </svg>
                                <h4>No Users Found</h4>
                                <p>We couldn't find any user accounts matching your criteria.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if($users->hasPages()): ?>
    <div class="flex justify-end mt-4 pagination">
        <?php echo e($users->links()); ?>

    </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.Layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views/admin/Users/index.blade.php ENDPATH**/ ?>