<?php $__env->startSection('title', 'Admin Dashboard — ' . App\Models\Setting::get('church_name', 'Grace Church')); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Dashboard</h1>
    <p class="text-sm mt-1" style="color:var(--text-muted)">Welcome back, Admin. Here is what's happening today.</p>
</div>


<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6 border-l-4" style="border-left-color: var(--amber);">
        <div class="text-[10px] uppercase font-bold tracking-widest mb-1" style="color:var(--text-muted)">Total Members</div>
        <div class="text-3xl font-cinzel tracking-tight" style="color:var(--gold)"><?php echo e(number_format($totalMembers)); ?></div>
        <div class="text-[10px] mt-2 flex items-center gap-1" style="color:var(--green)">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 15l7-7 7 7"/></svg>
            <span>Active Community</span>
        </div>
    </div>

    <div class="card p-6 border-l-4" style="border-left-color: var(--green);">
        <div class="text-[10px] uppercase font-bold tracking-widest mb-1" style="color:var(--text-muted)">Total Donations</div>
        <div class="text-3xl font-cinzel tracking-tight" style="color:var(--green)">₱<?php echo e(number_format($totalDonations, 0)); ?></div>
        <div class="text-[10px] mt-2 flex items-center gap-1 text-white opacity-60">
            <span>All-time contributions</span>
        </div>
    </div>

    <div class="card p-6 border-l-4" style="border-left-color: var(--gold);">
        <div class="text-[10px] uppercase font-bold tracking-widest mb-1" style="color:var(--text-muted)">Upcoming Events</div>
        <div class="text-3xl font-cinzel tracking-tight" style="color:var(--text-main)"><?php echo e($upcomingEvents); ?></div>
        <div class="text-[10px] mt-2 text-white opacity-60">Scheduled activities</div>
    </div>

    <div class="card p-6 border-l-4" style="border-left-color: var(--red);">
        <div class="text-[10px] uppercase font-bold tracking-widest mb-1" style="color:var(--text-muted)">Total Expenses</div>
        <div class="text-3xl font-cinzel tracking-tight" style="color:var(--red)">₱<?php echo e(number_format($totalExpenses, 0)); ?></div>
        <div class="text-[10px] mt-2 text-white opacity-60">Total operational spend</div>
    </div>
</div>


<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="card p-6">
        <h3 class="font-cinzel text-sm mb-6 uppercase tracking-widest" style="color:var(--gold)">Giving Analytics (Last 6 Months)</h3>
        <canvas id="givingChart" height="200"></canvas>
    </div>
    <div class="card p-6">
        <h3 class="font-cinzel text-sm mb-6 uppercase tracking-widest" style="color:var(--gold)">Attendance Trends</h3>
        <canvas id="attendanceChart" height="200"></canvas>
    </div>
</div>


<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    
    <div class="card col-span-1">
        <div class="p-5 border-b flex justify-between items-center" style="border-color:var(--border)">
            <h3 class="font-cinzel text-xs uppercase tracking-widest" style="color:var(--gold)">New Members</h3>
            <a href="<?php echo e(route('admin.members.index')); ?>" class="text-[10px] uppercase font-bold hover:underline" style="color:var(--text-muted)">View All</a>
        </div>
        <div class="p-2">
            <?php $__empty_1 = true; $__currentLoopData = $recentMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center gap-3 p-3 hover:bg-white/5 rounded-lg transition-colors">
                    <div class="w-8 h-8 rounded-full bg-amber-900/40 flex items-center justify-center text-xs font-bold" style="color:var(--gold)">
                        <?php echo e(substr($member->FirstName, 0, 1)); ?><?php echo e(substr($member->LastName, 0, 1)); ?>

                    </div>
                    <div>
                        <div class="text-sm font-semibold"><?php echo e($member->FirstName); ?> <?php echo e($member->LastName); ?></div>
                        <div class="text-[10px]" style="color:var(--text-muted)">Joined <?php echo e($member->created_at->diffForHumans()); ?></div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="p-5 text-sm text-center text-muted">No recent members</p>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="card col-span-1">
        <div class="p-5 border-b flex justify-between items-center" style="border-color:var(--border)">
            <h3 class="font-cinzel text-xs uppercase tracking-widest" style="color:var(--gold)">Upcoming Events</h3>
            <a href="<?php echo e(route('admin.events.index')); ?>" class="text-[10px] uppercase font-bold hover:underline" style="color:var(--text-muted)">View All</a>
        </div>
        <div class="p-2">
            <?php $__empty_1 = true; $__currentLoopData = $nextEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center gap-3 p-3 border-b border-white/5 last:border-0">
                    <div class="text-center bg-white/5 p-2 rounded min-w-[50px]">
                        <div class="text-xs font-bold uppercase" style="color:var(--gold)"><?php echo e($event->StartDateTime->format('M')); ?></div>
                        <div class="text-lg font-cinzel"><?php echo e($event->StartDateTime->format('d')); ?></div>
                    </div>
                    <div>
                        <div class="text-sm font-semibold"><?php echo e($event->Title); ?></div>
                        <div class="text-[10px]" style="color:var(--text-muted)"><?php echo e($event->Location); ?></div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="p-5 text-sm text-center text-muted">No upcoming events</p>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="card col-span-1">
        <div class="p-5 border-b flex justify-between items-center" style="border-color:var(--border)">
            <h3 class="font-cinzel text-xs uppercase tracking-widest" style="color:var(--gold)">Recent Giving</h3>
            <a href="<?php echo e(route('admin.donations.index')); ?>" class="text-[10px] uppercase font-bold hover:underline" style="color:var(--text-muted)">View All</a>
        </div>
        <div class="p-2">
            <?php $__empty_1 = true; $__currentLoopData = $recentDonations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center justify-between p-3 border-b border-white/5 last:border-0">
                    <div>
                        <div class="text-sm font-semibold"><?php echo e($donation->FundCategory); ?></div>
                        <div class="text-[10px]" style="color:var(--text-muted)"><?php echo e($donation->Date->format('M d, Y')); ?></div>
                    </div>
                    <div class="text-sm font-bold" style="color:var(--green)">+₱<?php echo e(number_format($donation->Amount, 2)); ?></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="p-5 text-sm text-center text-muted">No recent donations</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Giving Chart
    const givingCtx = document.getElementById('givingChart').getContext('2d');
    new Chart(givingCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($monthlyGiving->pluck('month')); ?>,
            datasets: [{
                label: 'Monthly Giving (₱)',
                data: <?php echo json_encode($monthlyGiving->pluck('total')); ?>,
                backgroundColor: 'rgba(200, 134, 10, 0.6)',
                borderColor: 'rgba(200, 134, 10, 1)',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#9a7a65' } },
                x: { grid: { display: false }, ticks: { color: '#9a7a65' } }
            },
            plugins: { legend: { display: false } }
        }
    });

    // Attendance Chart
    const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
    new Chart(attendanceCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($attendanceTrends->pluck('month')); ?>,
            datasets: [{
                label: 'Attendance',
                data: <?php echo json_encode($attendanceTrends->pluck('total')); ?>,
                borderColor: '#e6a020',
                backgroundColor: 'rgba(230, 160, 32, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#e6a020'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#9a7a65' } },
                x: { grid: { display: false }, ticks: { color: '#9a7a65' } }
            },
            plugins: { legend: { display: false } }
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.Layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\admin\dashboard.blade.php ENDPATH**/ ?>