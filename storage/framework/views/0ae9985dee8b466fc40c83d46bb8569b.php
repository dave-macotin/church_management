<?php $__env->startSection('title', 'Messages — ' . App\Models\Setting::get('church_name', 'Grace Church')); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Internal Messages</h1>
        <p class="text-sm mt-1" style="color:var(--text-muted)">Secure communication within the church community</p>
    </div>
    <a href="<?php echo e(route('messages.create')); ?>" class="btn btn-gold">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Message
    </a>
</div>

<div class="card overflow-hidden">
    <?php if($messages->isEmpty()): ?>
        <div class="p-12 text-center">
            <div class="text-4xl mb-4">📧</div>
            <p style="color:var(--text-muted)">Your inbox is empty</p>
        </div>
    <?php else: ?>
        <table class="w-full">
            <thead>
                <tr class="bg-black/20 text-[10px] uppercase tracking-widest text-muted">
                    <th class="p-4 text-left">Sender</th>
                    <th class="p-4 text-left">Subject</th>
                    <th class="p-4 text-left">Date</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="border-b border-white/5 hover:bg-white/5 transition-colors <?php echo e(!$msg->read_at ? 'font-bold bg-white/5' : ''); ?>">
                    <td class="p-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-amber-900/40 flex items-center justify-center text-xs font-bold" style="color:var(--gold)">
                                <?php echo e(substr($msg->sender->name, 0, 1)); ?>

                            </div>
                            <span><?php echo e($msg->sender->name); ?></span>
                        </div>
                    </td>
                    <td class="p-4">
                        <a href="<?php echo e(route('messages.show', $msg->id)); ?>" class="text-sm hover:text-gold transition-colors">
                            <?php echo e($msg->subject); ?>

                            <?php if(!$msg->read_at): ?>
                                <span class="ml-2 badge badge-amber">New</span>
                            <?php endif; ?>
                        </a>
                    </td>
                    <td class="p-4 text-xs text-muted"><?php echo e($msg->created_at->format('M d, Y h:i A')); ?></td>
                    <td class="p-4 text-right">
                        <a href="<?php echo e(route('messages.show', $msg->id)); ?>" class="btn btn-ghost px-4 py-1.5 text-xs">Read</a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div class="p-4">
            <?php echo e($messages->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($layout, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views/messages/index.blade.php ENDPATH**/ ?>