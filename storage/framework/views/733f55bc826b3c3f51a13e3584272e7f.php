<?php $__env->startSection('title', 'Child Check-In Kiosk — ' . App\Models\Setting::get('church_name', 'Grace Church')); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <div class="mb-8 text-center">
        <h1 class="font-cinzel text-3xl mb-2" style="color:var(--gold)">Child Safety Kiosk</h1>
        <p class="text-sm" style="color:var(--text-muted)">Secure check-in and check-out processing</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <div class="card p-8 flex flex-col justify-center items-center">
            <div class="w-16 h-16 bg-gold/10 rounded-full flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
            </div>
            
            <form method="POST" action="<?php echo e(route('admin.checkin.process')); ?>" class="w-full">
                <?php echo csrf_field(); ?>
                <div class="mb-6">
                    <label class="form-label text-center mb-4">Enter Parent's Pickup Code</label>
                    <input type="text" name="pickup_code" class="form-input text-center text-2xl font-cinzel tracking-[0.5em] h-16 uppercase" maxlength="6" required autofocus placeholder="XXXXXX">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <button type="submit" name="type" value="check-in" class="btn btn-gold h-14 text-lg">Check-In</button>
                    <button type="submit" name="type" value="check-out" class="btn btn-ghost h-14 text-lg border-gold text-gold">Check-Out</button>
                </div>
            </form>
        </div>

        
        <div class="card p-6">
            <h3 class="font-cinzel text-sm uppercase tracking-widest mb-4" style="color:var(--gold)">Recent Activity</h3>
            <?php
                $recentCheckIns = \App\Models\ChildCheckIn::with('child')->latest()->limit(8)->get();
            ?>

            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $recentCheckIns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-center justify-between p-3 rounded bg-white/5 border border-white/5">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full <?php echo e($log->type === 'check-in' ? 'bg-green-500' : 'bg-red-500'); ?>"></div>
                            <div>
                                <div class="text-sm font-bold"><?php echo e($log->child->FirstName); ?> <?php echo e($log->child->LastName); ?></div>
                                <div class="text-[10px]" style="color:var(--text-muted)"><?php echo e($log->timestamp->diffForHumans()); ?></div>
                            </div>
                        </div>
                        <div class="text-[10px] uppercase font-bold <?php echo e($log->type === 'check-in' ? 'text-green-500' : 'text-red-500'); ?>">
                            <?php echo e($log->type); ?>

                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-12 text-muted text-sm">No recent activity</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.Layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views/admin/Ministry/CheckIn/kiosk.blade.php ENDPATH**/ ?>