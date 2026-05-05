<?php $__env->startSection('title', 'Sermons — Grace Church Staff'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
    <div>
        <h1 class="font-cinzel text-2xl" style="color:var(--gold-mid)">Sermon Submissions</h1>
        <p class="text-sm mt-1" style="color:var(--gold-muted)">Manage and submit messages to the library</p>
    </div>
    <div class="flex gap-4">
        <div class="card px-4 py-2 flex items-center gap-2">
            <span class="text-xs font-bold uppercase tracking-wider opacity-50">Total:</span>
            <span class="text-sm font-bold text-gold-bright"><?php echo e($sermons->total()); ?></span>
        </div>
        <button onclick="document.getElementById('submitSermonForm').scrollIntoView({behavior:'smooth'})" class="btn btn-gold">
            Submit New Message
        </button>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
    
    <div class="lg:col-span-1">
        <div id="submitSermonForm" class="card p-6 sticky top-24" style="border: 1px solid var(--border); background: var(--bg-panel);">
            <h3 class="font-cinzel text-lg mb-6 flex items-center gap-2" style="color:var(--gold-mid)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                Submit Sermon
            </h3>
            <form method="POST" action="<?php echo e(route('staff.sermons.store')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="space-y-5">
                    <div>
                        <label class="info-label" style="font-size:10px; color:var(--gold-muted); text-transform:uppercase; margin-bottom:5px; display:block;">Title <span style="color:var(--red)">*</span></label>
                        <input type="text" name="title" class="form-input" placeholder="Message Title" required>
                    </div>
                    <div>
                        <label class="info-label" style="font-size:10px; color:var(--gold-muted); text-transform:uppercase; margin-bottom:5px; display:block;">Preacher <span style="color:var(--red)">*</span></label>
                        <input type="text" name="preacher" class="form-input" placeholder="Speaker Name" required>
                    </div>
                    <div>
                        <label class="info-label" style="font-size:10px; color:var(--gold-muted); text-transform:uppercase; margin-bottom:5px; display:block;">Date Preached <span style="color:var(--red)">*</span></label>
                        <input type="date" name="preached_at" value="<?php echo e(date('Y-m-d')); ?>" class="form-input" required>
                    </div>
                    <div>
                        <label class="info-label" style="font-size:10px; color:var(--gold-muted); text-transform:uppercase; margin-bottom:5px; display:block;">Video URL</label>
                        <input type="url" name="video_url" placeholder="https://youtube.com/..." class="form-input">
                    </div>
                    <div>
                        <label class="info-label" style="font-size:10px; color:var(--gold-muted); text-transform:uppercase; margin-bottom:5px; display:block;">Custom Thumbnail</label>
                        <input type="file" name="thumbnail_url" class="form-input" accept="image/*">
                    </div>
                    <div>
                        <label class="info-label" style="font-size:10px; color:var(--gold-muted); text-transform:uppercase; margin-bottom:5px; display:block;">Series</label>
                        <input type="text" name="series" class="form-input" placeholder="Sermon Series Name">
                    </div>
                    <div>
                        <label class="info-label" style="font-size:10px; color:var(--gold-muted); text-transform:uppercase; margin-bottom:5px; display:block;">Description</label>
                        <textarea name="description" class="form-input" rows="3" placeholder="Brief summary..."></textarea>
                    </div>
                </div>
                <div class="mt-8">
                    <button type="submit" class="btn btn-gold w-full py-3 shadow-lg">Submit for Approval</button>
                </div>
            </form>
        </div>
    </div>

    
    <div class="lg:col-span-2">
        <h2 class="font-cinzel text-xl mb-6 flex items-center gap-2" style="color:var(--gold-mid)">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            Sermon Catalog
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $sermons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sermon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="card overflow-hidden flex flex-col group transition-all duration-300 hover:-translate-y-1" style="<?php echo e(!$sermon->is_approved ? 'border-color: rgba(250,199,117,0.3);' : ''); ?>">
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
                                <span class="bg-amber-500/20 text-amber-500 border border-amber-500/30 px-3 py-1 rounded text-[10px] font-bold uppercase tracking-tighter backdrop-blur-sm shadow-xl">Pending Review</span>
                            </div>
                        <?php endif; ?>

                        <div class="absolute bottom-2 right-2 badge badge-muted text-[10px]" style="background: rgba(0,0,0,0.6);"><?php echo e($sermon->preached_at->format('M d, Y')); ?></div>
                    </div>

                    <div class="p-5 flex-1 flex flex-col">
                        <div class="text-[10px] uppercase tracking-widest font-bold mb-1" style="color:var(--gold-muted)"><?php echo e($sermon->series ?? 'Standalone'); ?></div>
                        <h3 class="font-cinzel text-base mb-2" style="color:var(--gold-mid)"><?php echo e($sermon->title); ?></h3>
                        
                        <div class="mt-auto pt-4 border-t border-white/5 flex justify-between items-center">
                            <span class="text-xs font-semibold italic" style="color:var(--gold-muted)">Pr. <?php echo e($sermon->preacher); ?></span>
                            <a href="<?php echo e(route('sermons.show', $sermon->id)); ?>" class="text-[10px] font-bold text-gold-bright hover:text-gold-mid transition-colors uppercase tracking-wider">Preview</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full py-16 text-center card bg-panel/30 border-dashed">
                    <p style="color:var(--gold-muted)">No sermons submitted yet.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="mt-8 flex justify-end">
            <?php echo e($sermons->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('staff.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\staff\sermons\index.blade.php ENDPATH**/ ?>