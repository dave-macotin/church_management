<?php $__env->startSection('title', 'Attendance — Grace Church CMS'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Attendance</h1>
        <p class="text-sm mt-1" style="color:var(--text-muted)"><?php echo e($attendances->total()); ?> records</p>
    </div>
    <div class="flex gap-2">
        <a href="<?php echo e(route('admin.attendance.archived')); ?>" class="btn btn-ghost" style="font-size:0.8rem">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
            View Archived
        </a>
        <a href="<?php echo e(route('admin.attendance.create')); ?>" class="btn btn-gold">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Log Attendance
        </a>
    </div>
</div>

<form method="GET" class="flex gap-3 mb-5">
    <div class="search-wrap flex-1">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search by member name…" class="form-input">
    </div>
    <select name="status" class="form-input" style="width:160px">
        <option value="">All Statuses</option>
        <option value="Present" <?php echo e(request('status') === 'Present' ? 'selected' : ''); ?>>Present</option>
        <option value="Absent"  <?php echo e(request('status') === 'Absent'  ? 'selected' : ''); ?>>Absent</option>
        <option value="Excused" <?php echo e(request('status') === 'Excused' ? 'selected' : ''); ?>>Excused</option>
    </select>
    <input type="date" name="date" value="<?php echo e(request('date')); ?>" class="form-input" style="width:170px">
    <button type="submit" class="btn btn-ghost">Filter</button>
    <?php if(request('search') || request('status') || request('date')): ?>
        <a href="<?php echo e(route('admin.attendance.index')); ?>" class="btn btn-ghost">Clear</a>
    <?php endif; ?>
</form>

<div class="card overflow-hidden">
    <div class="data-table-container">
        <table>
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Event</th>
                    <th>Status</th>
                    <th>Check In/Out</th>
                    <th>Log Date</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="user-avatar" 
                                 style="<?php echo e($att->member?->profile_picture ? 'background-image:url('.asset('storage/'.$att->member->profile_picture).'); color:transparent;' : 'background:var(--bg-hover);color:var(--gold-mid);'); ?>">
                                <?php if(!$att->member?->profile_picture): ?>
                                    <?php echo e($att->member ? strtoupper(substr($att->member->FirstName,0,1).substr($att->member->LastName,0,1)) : '?'); ?>

                                <?php endif; ?>
                            </div>
                            <span class="font-medium"><?php echo e($att->member ? $att->member->FirstName . ' ' . $att->member->LastName : '—'); ?></span>
                        </div>
                    </td>
                    <td>
                        <span class="text-sm" style="color:var(--gold-muted)"><?php echo e($att->event?->Title ?? 'Service/Gathering'); ?></span>
                    </td>
                    <td>
                        <?php if($att->Status === 'Present'): ?>
                            <span class="badge badge-green">Present</span>
                        <?php elseif($att->Status === 'Absent'): ?>
                            <span class="badge badge-red">Absent</span>
                        <?php else: ?>
                            <span class="badge badge-amber">Excused</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($att->CheckInTime): ?>
                            <div class="text-xs">
                                <span style="color:var(--green);font-weight:700">In:</span> <?php echo e($att->CheckInTime->format('g:i A')); ?>

                                <?php if($att->CheckOutTime): ?>
                                    <br><span style="color:var(--amber);font-weight:700">Out:</span> <?php echo e($att->CheckOutTime->format('g:i A')); ?>

                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <span class="text-xs italic" style="color:var(--gold-muted)">No time logs</span>
                        <?php endif; ?>
                    </td>
                    <td style="color:var(--gold-muted)"><?php echo e($att->Timestamp?->format('M d, Y') ?? '—'); ?></td>
                    <td>
                        <div class="flex items-center gap-2 justify-end">
                            <form method="POST" action="<?php echo e(route('admin.attendance.archive', $att)); ?>"
                                  onsubmit="return confirm('Archive this attendance record?')">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-ghost btn-sm" style="color:var(--gold-bright); border-color:rgba(239, 159, 39, 0.2)"
                                        title="Archive this record">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                                    Archive
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h4>No Attendance Records</h4>
                            <p>No presence logs found for the selected filters.</p>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="flex justify-end mt-4 pagination"><?php echo e($attendances->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.Layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views/admin/Ministry/Attendance/index.blade.php ENDPATH**/ ?>