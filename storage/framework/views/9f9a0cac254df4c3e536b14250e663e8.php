<?php $__env->startSection('title', 'My Groups'); ?>
<?php $__env->startSection('page_title', 'My Groups'); ?>

<?php $__env->startSection('content'); ?>
<div style="max-width:900px; margin:0 auto;">
    <div style="margin-bottom:32px;">
        <h3 style="font-family:Georgia, serif; font-size:22px; color:var(--gold-bright); margin-bottom:8px;">Ministry Groups</h3>
        <p style="color:var(--gold-muted); font-size:14px;">Connect with your church community. Join groups to stay involved.</p>
    </div>

    <?php if($groups->isEmpty()): ?>
        <div style="text-align:center; padding:80px 40px; background:var(--bg-card); border-radius:var(--radius); border:1px dashed var(--border);">
            <svg style="width:48px;height:48px;color:var(--gold-muted);margin:0 auto 16px;opacity:0.5;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="1.5"/></svg>
            <div style="color:var(--cream); font-size:16px; font-weight:600; margin-bottom:8px;">No groups available yet.</div>
            <div style="color:var(--gold-muted); font-size:13px;">Check back later or contact your administrator.</div>
        </div>
    <?php else: ?>
        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(320px,1fr)); gap:20px;">
            <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $joined = in_array($group->GroupID, $joinedIds); ?>
            <div class="card" style="padding:24px; position:relative; overflow:hidden; transition:transform 0.2s; border:1px solid <?php echo e($joined ? 'rgba(239,159,39,0.35)' : 'var(--border)'); ?>;">
                
                <div style="position:absolute; top:-20px; right:-20px; width:90px; height:90px; background:var(--purple-bg); border-radius:50%; opacity:0.2;"></div>

                <div style="display:flex; align-items:center; gap:14px; margin-bottom:16px;">
                    <div style="width:48px; height:48px; border-radius:10px; background:var(--purple-bg); color:var(--purple); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <svg style="width:24px;height:24px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="1.8"/></svg>
                    </div>
                    <div style="flex:1; min-width:0;">
                        <div style="font-family:Georgia,serif; font-size:16px; color:var(--gold-mid); font-weight:600;"><?php echo e($group->GroupName); ?></div>
                        <?php if($joined): ?>
                            <span style="font-size:10px; color:var(--green); background:var(--green-bg); padding:2px 8px; border-radius:99px; border:1px solid rgba(93,202,165,0.2);">Member</span>
                        <?php endif; ?>
                    </div>
                </div>

                <p style="color:var(--cream); font-size:13px; line-height:1.6; margin-bottom:20px; opacity:0.8;">
                    <?php echo e($group->Description ?? 'No description available.'); ?>

                </p>

                <?php if($joined): ?>
                    <form method="POST" action="<?php echo e(route('member.groups.leave', $group->GroupID)); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" style="width:100%; padding:10px; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; background:transparent; border:1px solid var(--red); color:var(--red); transition:all 0.2s;"
                                onmouseover="this.style.background='var(--red-bg)'" onmouseout="this.style.background='transparent'">
                            Leave Group
                        </button>
                    </form>
                <?php else: ?>
                    <form method="POST" action="<?php echo e(route('member.groups.join', $group->GroupID)); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" style="width:100%; padding:10px; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; background:var(--gold-bright); border:none; color:#000; transition:all 0.2s;"
                                onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                            Join Group
                        </button>
                    </form>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('member.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\member\groups.blade.php ENDPATH**/ ?>