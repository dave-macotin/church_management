<?php $__env->startSection('title', 'Volunteer Management — ' . App\Models\Setting::get('church_name', 'Grace Church')); ?>

<?php $__env->startSection('content'); ?>
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    
    <div class="col-span-1">
        <div class="card p-6">
            <h3 class="font-cinzel text-lg mb-4" style="color:var(--gold)">Create Opportunity</h3>
            <form method="POST" action="<?php echo e(route('admin.volunteering.store')); ?>">
                <?php echo csrf_field(); ?>
                <div class="mb-4">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-input" required placeholder="e.g., Sunday Choir">
                </div>
                <div class="mb-4">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-input">
                        <option value="Media">Media & Tech</option>
                        <option value="Greeting">Greeting & Ushering</option>
                        <option value="Music">Music & Worship</option>
                        <option value="Children">Children's Ministry</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="form-label">Date</label>
                        <input type="date" name="date" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Time Slot</label>
                        <input type="text" name="time_slot" class="form-input" placeholder="8:00 AM">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Volunteers Needed</label>
                    <input type="number" name="needed_volunteers" class="form-input" value="1" min="1">
                </div>
                <div class="mb-6">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-input" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-gold w-full tracking-widest uppercase text-[10px] font-bold">Launch Opportunity</button>
            </form>
        </div>
    </div>

    
    <div class="col-span-1 xl:col-span-2">
        <div class="card overflow-hidden">
            <div class="p-5 border-b border-white/5 flex justify-between items-center bg-black/10">
                <h3 class="font-cinzel text-sm uppercase tracking-widest text-gold">Active Opportunities</h3>
            </div>
            
            <table class="w-full">
                <thead>
                    <tr class="bg-black/20 text-[10px] uppercase tracking-widest text-muted">
                        <th class="p-4 text-left">Opportunity</th>
                        <th class="p-4 text-left">Date/Time</th>
                        <th class="p-4 text-center">Needed</th>
                        <th class="p-4 text-center">Registrations</th>
                        <th class="p-4 text-right">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $opportunities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                            <td class="p-4">
                                <div class="font-bold text-sm"><?php echo e($opp->title); ?></div>
                                <div class="text-[10px] text-muted"><?php echo e($opp->category); ?></div>
                            </td>
                            <td class="p-4 text-xs">
                                <?php echo e($opp->date ? \Carbon\Carbon::parse($opp->date)->format('M d, Y') : 'Ongoing'); ?><br>
                                <span class="text-gold opacity-70"><?php echo e($opp->time_slot); ?></span>
                            </td>
                            <td class="p-4 text-center text-sm font-cinzel"><?php echo e($opp->needed_volunteers); ?></td>
                            <td class="p-4 text-center">
                                <span class="badge <?php echo e($opp->registrations_count > 0 ? 'badge-amber' : 'badge-muted'); ?>">
                                    <?php echo e($opp->registrations_count); ?> signed up
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <span class="badge <?php echo e($opp->is_active ? 'badge-green' : 'badge-red'); ?>">
                                    <?php echo e($opp->is_active ? 'Active' : 'Closed'); ?>

                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="p-12 text-center text-muted text-sm">No opportunities created yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="p-4 border-t border-white/5">
                <?php echo e($opportunities->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.Layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\admin\Operations\Volunteering\index.blade.php ENDPATH**/ ?>