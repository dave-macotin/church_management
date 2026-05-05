<?php $__env->startSection('title', 'Events — Grace Church Staff'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
    <div>
        <h1 class="font-cinzel text-2xl" style="color:var(--gold-mid)">Ministry Events</h1>
        <p class="text-sm mt-1" style="color:var(--gold-muted)"><?php echo e($events->total()); ?> events cataloged</p>
    </div>
    <a href="<?php echo e(route('staff.events.create')); ?>" class="btn btn-gold">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Propose Event
    </a>
</div>

<form method="GET" class="flex flex-col md:flex-row gap-4 mb-8">
    <div class="relative flex-1">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gold-muted/50" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
        </svg>
        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search events…" class="form-input !pl-10">
    </div>
    <div class="flex gap-2">
        <select name="filter" class="form-input" style="width:160px">
            <option value="">All Events</option>
            <option value="upcoming" <?php echo e(request('filter') === 'upcoming' ? 'selected' : ''); ?>>Upcoming</option>
            <option value="past"     <?php echo e(request('filter') === 'past'     ? 'selected' : ''); ?>>Past</option>
            <option value="pending"  <?php echo e(request('filter') === 'pending'  ? 'selected' : ''); ?>>Pending Approval</option>
        </select>
        <button type="submit" class="btn btn-gold">Filter</button>
        <?php if(request('search') || request('filter')): ?>
            <a href="<?php echo e(route('staff.events.index')); ?>" class="btn btn-ghost">Clear</a>
        <?php endif; ?>
    </div>
</form>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    <?php $__empty_1 = true; $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="card overflow-hidden flex flex-col group transition-all duration-300 hover:-translate-y-1" style="<?php echo e(!$event->is_approved ? 'border-color: rgba(250,199,117,0.3);' : ''); ?>">
            <div class="aspect-video bg-black/40 relative">
                <?php if($event->image): ?>
                    <img src="<?php echo e(asset('storage/' . $event->image)); ?>" class="w-full h-full object-cover <?php echo e(!$event->is_approved ? 'opacity-40 grayscale' : 'opacity-80 group-hover:opacity-100'); ?> transition-all" alt="Event">
                <?php else: ?>
                    <div class="w-full h-full flex flex-col items-center justify-center bg-panel/50 text-gold-muted/30">
                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    </div>
                <?php endif; ?>
                
                <?php if(!$event->is_approved): ?>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="bg-amber-500/20 text-amber-500 border border-amber-500/30 px-3 py-1 rounded text-[10px] font-bold uppercase tracking-tighter backdrop-blur-sm shadow-xl">Awaiting Approval</span>
                    </div>
                <?php endif; ?>

                <div class="absolute bottom-2 right-2 badge badge-muted text-[10px]" style="background: rgba(0,0,0,0.6);">
                    <?php echo e($event->StartDateTime?->format('M d, Y')); ?>

                </div>
            </div>

            <div class="p-5 flex-1 flex flex-col">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-cinzel text-base" style="color:var(--gold-mid)"><?php echo e($event->Title); ?></h3>
                    <?php if($event->is_approved && $event->StartDateTime?->isFuture()): ?>
                         <span class="badge badge-green text-[9px]">Active</span>
                    <?php endif; ?>
                </div>
                
                <div class="space-y-1.5 mb-4 opacity-70">
                    <div class="flex items-center gap-2 text-[11px]" style="color:var(--cream)">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        <?php echo e($event->Location ?? 'Grace Church Main Hall'); ?>

                    </div>
                    <div class="flex items-center gap-2 text-[11px]" style="color:var(--cream)">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <?php echo e($event->StartDateTime?->format('g:i A')); ?>

                    </div>
                </div>

                <div class="mt-auto pt-4 border-t border-white/5 flex flex-col gap-3">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-bold uppercase tracking-wider opacity-40">Staff Control</span>
                        <div class="flex gap-2">
                             <a href="<?php echo e(route('staff.events.show', $event)); ?>" class="btn btn-gold flex items-center gap-2 text-[10px] py-1.5 px-3 h-auto">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Details
                            </a>
                            <a href="<?php echo e(route('staff.events.edit', $event)); ?>" class="btn btn-gold flex items-center gap-2 text-[10px] py-1.5 px-3 h-auto" style="background:rgba(250,199,117,0.05); color:rgba(250,199,117,0.6); border-color:rgba(250,199,117,0.1);">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full py-16 text-center card bg-panel/30 border-dashed">
            <p style="color:var(--gold-muted)">No ministry events found.</p>
        </div>
    <?php endif; ?>
</div>

<div class="mt-12 flex justify-end">
    <?php echo e($events->appends(request()->query())->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('staff.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views/staff/events/index.blade.php ENDPATH**/ ?>