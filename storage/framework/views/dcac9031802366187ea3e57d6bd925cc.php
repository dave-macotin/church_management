<?php $__env->startSection('title', 'Sermons — Grace Church CMS'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="font-cinzel text-2xl" style="color:var(--gold-mid)">Sermon Management</h1>
        <p class="text-sm mt-1" style="color:var(--gold-muted)"><?php echo e($sermons->total()); ?> sermons in library</p>
    </div>
    <button onclick="document.getElementById('addSermonForm').scrollIntoView({behavior:'smooth'})" class="btn btn-gold">
        Add New Sermon
    </button>
</div>


<div id="addSermonForm" class="card p-6 max-w-2xl mb-12" style="border: 1px solid var(--gold-bright); background: linear-gradient(135deg, var(--bg-card) 0%, #2a1a0a 100%);">
    <h3 class="font-cinzel text-lg mb-6 flex items-center gap-2" style="color:var(--gold-mid)">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
        New Sermon Entry
    </h3>
    <form method="POST" action="<?php echo e(route('admin.sermons.store')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="info-label" style="font-size:11px; color:var(--gold-muted); text-transform:uppercase; margin-bottom:6px; display:block;">Title <span style="color:var(--red)">*</span></label>
                <input type="text" name="title" class="form-input" placeholder="e.g. Walking in the Light" required>
            </div>
            <div>
                <label class="info-label" style="font-size:11px; color:var(--gold-muted); text-transform:uppercase; margin-bottom:6px; display:block;">Preacher <span style="color:var(--red)">*</span></label>
                <input type="text" name="preacher" class="form-input" placeholder="e.g. Pastor John Doe" required>
            </div>
            <div>
                <label class="info-label" style="font-size:11px; color:var(--gold-muted); text-transform:uppercase; margin-bottom:6px; display:block;">Date Preached <span style="color:var(--red)">*</span></label>
                <input type="date" name="preached_at" value="<?php echo e(date('Y-m-d')); ?>" class="form-input" required>
            </div>
            <div class="md:col-span-2">
                <label class="info-label" style="font-size:11px; color:var(--gold-muted); text-transform:uppercase; margin-bottom:6px; display:block;">Video URL (YouTube/Vimeo)</label>
                <input type="url" name="video_url" placeholder="https://youtube.com/watch?v=..." class="form-input">
            </div>
            <div>
                <label class="info-label" style="font-size:11px; color:var(--gold-muted); text-transform:uppercase; margin-bottom:6px; display:block;">Sermon Series</label>
                <input type="text" name="series" class="form-input" placeholder="e.g. The Gospel of John">
            </div>
            <div>
                <label class="info-label" style="font-size:11px; color:var(--gold-muted); text-transform:uppercase; margin-bottom:6px; display:block;">Custom Thumbnail (Optional)</label>
                <input type="file" name="thumbnail_url" class="form-input" accept="image/*">
                <small class="text-[10px] opacity-50 mt-1 block">Fallbacks to YouTube thumbnail if empty</small>
            </div>
            <div class="md:col-span-2">
                <label class="info-label" style="font-size:11px; color:var(--gold-muted); text-transform:uppercase; margin-bottom:6px; display:block;">Description / Summary</label>
                <textarea name="description" class="form-input" rows="3" placeholder="Brief overview of the message..."></textarea>
            </div>
        </div>
        <div class="mt-8 flex justify-end">
            <button type="submit" class="btn btn-gold px-8 py-3">Add to Library</button>
        </div>
    </form>
</div>

<h2 class="font-cinzel text-xl mb-6 flex items-center gap-2" style="color:var(--gold-mid)">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
    Library Contents
</h2>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    <?php $__empty_1 = true; $__currentLoopData = $sermons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sermon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="card overflow-hidden flex flex-col group transition-all duration-300 hover:-translate-y-1" style="<?php echo e(!$sermon->is_approved ? 'border-color: var(--accent);' : ''); ?>">
            <div class="aspect-video bg-black/40 relative">
                <?php
                    $thumb = $sermon->thumbnail_url;
                    if ($thumb && !str_starts_with($thumb, 'http')) {
                        $thumb = asset('storage/' . $thumb);
                    } elseif (!$thumb && $sermon->video_url) {
                        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $sermon->video_url, $match);
                        $youtube_id = $match[1] ?? null;
                        $thumb = $youtube_id ? "https://img.youtube.com/vi/{$youtube_id}/mqdefault.jpg" : asset('images/hero.png');
                    } else {
                        $thumb = asset('images/hero.png');
                    }
                ?>
                <img src="<?php echo e($thumb); ?>" class="w-full h-full object-cover <?php echo e(!$sermon->is_approved ? 'opacity-40 grayscale' : 'opacity-80 group-hover:opacity-100'); ?> transition-all" alt="Sermon">
                
                <?php if(!$sermon->is_approved): ?>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="badge badge-amber px-4 py-2 text-xs font-bold uppercase shadow-2xl">Pending Approval</span>
                    </div>
                <?php endif; ?>

                <div class="absolute bottom-2 right-2 badge badge-muted text-[10px]" style="background: rgba(0,0,0,0.6);"><?php echo e($sermon->preached_at->format('M d, Y')); ?></div>
            </div>

            <div class="p-5 flex-1 flex flex-col">
                <div class="text-[10px] uppercase tracking-widest font-bold mb-1" style="color:var(--gold-muted)"><?php echo e($sermon->series ?? 'Standalone Message'); ?></div>
                <h3 class="font-cinzel text-lg mb-2" style="color:var(--gold-mid)"><?php echo e($sermon->title); ?></h3>
                <p class="text-xs line-clamp-2 mb-4" style="color:var(--cream); opacity: 0.7;"><?php echo e($sermon->description); ?></p>
                
                <div class="mt-auto pt-4 border-t border-white/5 flex flex-col gap-3">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-semibold italic" style="color:var(--gold-muted)">Pr. <?php echo e($sermon->preacher); ?></span>
                        <div class="flex gap-2">
                             <?php if(!$sermon->is_approved): ?>
                                <form method="POST" action="<?php echo e(route('admin.sermons.approve', $sermon->id)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="text-[10px] font-bold text-green-400 hover:text-green-300 transition-colors uppercase tracking-wider">Approve</button>
                                </form>
                            <?php endif; ?>
                            <a href="<?php echo e(route('sermons.show', $sermon->id)); ?>" class="text-[10px] font-bold text-gold-bright hover:text-gold-mid transition-colors uppercase tracking-wider">Preview</a>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-[10px] opacity-40">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Submitted by: <?php echo e($sermon->submittedBy->name ?? 'System'); ?>

                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full py-20 text-center card bg-panel/30 border-dashed">
            <div class="text-5xl mb-4 opacity-20">📖</div>
            <p style="color:var(--gold-muted)">The sermon library is currently empty.</p>
        </div>
    <?php endif; ?>
</div>

<div class="mt-12 flex justify-end">
    <?php echo e($sermons->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.Layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\admin\Ministry\Sermons\index.blade.php ENDPATH**/ ?>