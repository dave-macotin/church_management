<?php $__env->startSection('header'); ?>
<div class="flex justify-between items-center">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        <?php echo e(__('Sermon Details')); ?>

    </h2>
    <a href="<?php echo e(route('sermons.index')); ?>" class="text-indigo-400 hover:text-indigo-300">
        &larr; Back to Library
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 sm:p-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-2"><?php echo e($sermon->title); ?></h3>
                
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 dark:text-gray-400 mb-6">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <?php echo e($sermon->preacher); ?>

                    </span>
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <?php echo e(\Carbon\Carbon::parse($sermon->preached_at)->format('F j, Y')); ?>

                    </span>
                    <?php if($sermon->series): ?>
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Series: <?php echo e($sermon->series); ?>

                    </span>
                    <?php endif; ?>
                </div>

                <?php if($sermon->video_url): ?>
                <div class="aspect-w-16 aspect-h-9 mb-8 rounded-lg overflow-hidden shadow-lg">
                    <iframe src="<?php echo e(str_replace('watch?v=', 'embed/', $sermon->video_url)); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-full min-h-[400px]"></iframe>
                </div>
                <?php endif; ?>

                <div class="prose dark:prose-invert max-w-none">
                    <h4 class="text-xl font-semibold mb-3 text-gray-800 dark:text-gray-200">Description / Notes</h4>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line"><?php echo e($sermon->description ?? 'No description provided for this sermon.'); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($layout ?? 'member.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\sermons\show.blade.php ENDPATH**/ ?>