<?php $__env->startSection('title', 'Sermon Library — ' . App\Models\Setting::get('church_name', 'Grace Church')); ?>
<?php $__env->startSection('page_title', 'Sermon Library'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8 p-6 card" style="background: linear-gradient(135deg, var(--bg-card) 0%, var(--bg-hover) 100%);">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-cinzel text-2xl" style="color:var(--gold-mid)">Spiritual Nourishment</h1>
            <p class="text-sm mt-1" style="color:var(--gold-muted)">Watch and listen to our previous sermon series</p>
        </div>
        <div class="flex gap-2">
            <span class="badge badge-active"><?php echo e($sermons->total()); ?> recorded messages</span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php $__empty_1 = true; $__currentLoopData = $sermons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sermon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="card overflow-hidden flex flex-col group transition-all duration-300 hover:-translate-y-1">
            <div class="aspect-video bg-black/40 relative">
                <?php if($sermon->video_url): ?>
                    <?php
                        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $sermon->video_url, $match);
                        $youtube_id = $match[1] ?? null;
                    ?>
                    <?php if($youtube_id): ?>
                        <img src="https://img.youtube.com/vi/<?php echo e($youtube_id); ?>/mqdefault.jpg" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity" alt="Sermon Thumbnail">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-12 h-12 bg-accent rounded-full flex items-center justify-center text-white shadow-xl transform group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="absolute bottom-2 right-2 badge badge-muted" style="background: rgba(0,0,0,0.6);"><?php echo e($sermon->preached_at->format('M d, Y')); ?></div>
            </div>
            <div class="p-5 flex-1 flex flex-col">
                <div class="text-[10px] uppercase tracking-widest font-bold mb-1" style="color:var(--gold-muted)"><?php echo e($sermon->series ?? 'Standalone Message'); ?></div>
                <h3 class="font-cinzel text-lg mb-2" style="color:var(--gold-mid)"><?php echo e($sermon->title); ?></h3>
                <p class="text-xs line-clamp-2 mb-4" style="color:var(--cream); opacity: 0.7;"><?php echo e($sermon->description); ?></p>
                <div class="mt-auto pt-4 border-t border-white/5 flex justify-between items-center">
                    <span class="text-xs font-semibold italic" style="color:var(--gold-muted)">Pr. <?php echo e($sermon->preacher); ?></span>
                    <a href="<?php echo e(route('sermons.show', $sermon->id)); ?>" class="btn btn-gold text-xs py-1.5 px-4 h-auto">Watch Now</a>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full py-20 text-center card">
            <div class="text-5xl mb-4 opacity-20">📖</div>
            <p style="color:var(--gold-muted)">No sermons have been uploaded to the library yet.</p>
        </div>
    <?php endif; ?>
</div>

<div class="mt-8">
    <?php echo e($sermons->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('member.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\sermons\index.blade.php ENDPATH**/ ?>