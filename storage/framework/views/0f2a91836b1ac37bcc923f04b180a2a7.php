<?php $__env->startSection('title', 'Compose Message — ' . App\Models\Setting::get('church_name', 'Grace Church')); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Compose Message</h1>
    <p class="text-sm mt-1" style="color:var(--text-muted)">Send a new message to a member or staff</p>
</div>

<div class="card p-6 max-w-2xl">
    <form method="POST" action="<?php echo e(route('messages.store')); ?>">
        <?php echo csrf_field(); ?>
        
        <div class="mb-4">
            <label class="form-label">Recipient</label>
            <select name="receiver_id" class="form-input" required>
                <option value="">Select a recipient...</option>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?> (<?php echo e(ucfirst($user->role)); ?>)</option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="mb-4">
            <label class="form-label">Subject</label>
            <input type="text" name="subject" class="form-input" required placeholder="Subject of your message">
        </div>

        <div class="mb-6">
            <label class="form-label">Message Content</label>
            <textarea name="content" class="form-input" rows="8" required placeholder="Write your message here..."></textarea>
        </div>

        <div class="flex justify-end gap-3">
            <a href="<?php echo e(route('messages.index')); ?>" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-gold px-8">Send Message</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($layout, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\messages\create.blade.php ENDPATH**/ ?>