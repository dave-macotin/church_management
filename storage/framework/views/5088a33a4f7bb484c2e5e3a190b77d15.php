<?php $__env->startSection('title', 'My Donations'); ?>
<?php $__env->startSection('page_title', 'My Giving'); ?>

<?php $__env->startSection('extra_css'); ?>
<style>
    .giving-section { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }
    .stat-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px; position: relative; overflow: hidden; }
    .stat-card.gold::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 2px; background: linear-gradient(90deg, var(--gold-bright), transparent); }
    .stat-card.green::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 2px; background: linear-gradient(90deg, var(--green), transparent); }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
    <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:16px; margin-bottom:24px;">
        <div class="stat-card gold">
            <div style="font-size:11px; color:var(--gold-muted); text-transform:uppercase; margin-bottom:8px;">Total Given</div>
            <div style="font-size:28px; font-weight:700; color:var(--gold-bright); font-family:Georgia, serif;">₱<?php echo e(number_format($totalDonations, 2)); ?></div>
        </div>
        <div class="stat-card gold">
            <div style="font-size:11px; color:var(--gold-muted); text-transform:uppercase; margin-bottom:8px;">Donations This Year</div>
            <div style="font-size:28px; font-weight:700; color:var(--cream); font-family:Georgia, serif;"><?php echo e($donationCount); ?></div>
        </div>
        <div class="stat-card green" style="display:flex; align-items:center; justify-content:center; cursor:pointer;" onclick="openDonateModal()">
            <div style="text-align:center;">
                <div style="font-size:14px; font-weight:700; color:var(--green); display:flex; align-items:center; gap:8px;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Donate Now
                </div>
            </div>
        </div>
    </div>

    <div class="giving-section">
        
        <div class="panel">
            <div class="panel-header">
                <span class="panel-title">Giving History</span>
            </div>
            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse; font-size:13px;">
                    <thead>
                        <tr style="background:var(--bg-hover);">
                            <th style="padding:12px 20px; text-align:left; color:var(--gold-muted);">Date</th>
                            <th style="padding:12px 20px; text-align:left; color:var(--gold-muted);">Fund Category</th>
                            <th style="padding:12px 20px; text-align:left; color:var(--gold-muted);">Method</th>
                            <th style="padding:12px 20px; text-align:right; color:var(--gold-muted);">Amount</th>
                            <th style="padding:12px 20px; text-align:center; color:var(--gold-muted);">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $donations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr style="border-bottom:1px solid var(--border-soft);">
                            <td style="padding:12px 20px; color:var(--cream);"><?php echo e(\Carbon\Carbon::parse($donation->Date)->format('M d, Y')); ?></td>
                            <td style="padding:12px 20px; color:var(--gold-mid);"><?php echo e($donation->FundCategory); ?></td>
                            <td style="padding:12px 20px; color:var(--gold-muted); font-size:12px;"><?php echo e($donation->PaymentMethod ?? 'N/A'); ?></td>
                            <td style="padding:12px 20px; text-align:right; font-family:Outfit; font-weight:700; color:var(--gold-bright);">₱<?php echo e(number_format($donation->Amount, 2)); ?></td>
                            <td style="padding:12px 20px; text-align:center;">
                                <a href="<?php echo e(route('member.donations.receipt', $donation->DonationID)); ?>" target="_blank" class="btn btn-ghost" style="padding:4px 10px; font-size:11px;">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right:4px;"><path d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" stroke-width="2"/></svg>
                                    Receipt
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" style="padding:40px; text-align:center; color:var(--gold-muted);">No donations found.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if($donations->hasPages()): ?>
                <div style="padding:16px; border-top:1px solid var(--border-soft);">
                    <?php echo e($donations->links()); ?>

                </div>
            <?php endif; ?>
        </div>

        
        <div style="display:flex; flex-direction:column; gap:20px;">
            <div class="panel">
                <div class="panel-header"><span class="panel-title">Breakdown</span></div>
                <div class="panel-body">
                    <?php $__currentLoopData = $fundBreakdown; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div style="margin-bottom:16px;">
                        <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:6px;">
                            <span style="color:var(--gold-muted);"><?php echo e($fb['name']); ?></span>
                            <span style="color:var(--gold-bright); font-weight:700;">₱<?php echo e(number_format($fb['amount'], 0)); ?></span>
                        </div>
                        <?php $percent = $totalDonations > 0 ? ($fb['amount'] / $totalDonations) * 100 : 0; ?>
                        <div style="height:4px; background:var(--bg-input); border-radius:2px; overflow:hidden;">
                            <div style="height:100%; background:var(--gold-bright); width:<?php echo e($percent); ?>%;"></div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>

    
    <div id="donateModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.8); z-index:2000; align-items:center; justify-content:center; padding:20px;">
        <div class="card" style="width:100%; max-width:400px; padding:32px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
                <h3 style="font-family:Georgia, serif; font-size:20px; color:var(--gold-mid);">Support our Ministry</h3>
                <button onclick="closeDonateModal()" style="background:none; border:none; color:var(--gold-muted); cursor:pointer;"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            
            <form action="<?php echo e(route('member.donations.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div style="margin-bottom:20px;">
                    <label style="font-size:11px; color:var(--gold-muted); text-transform:uppercase; display:block; margin-bottom:8px;">Amount (₱)</label>
                    <input type="number" name="Amount" step="0.01" class="form-input" placeholder="0.00" required>
                </div>
                
                <div style="margin-bottom:20px;">
                    <label style="font-size:11px; color:var(--gold-muted); text-transform:uppercase; display:block; margin-bottom:8px;">Fund Category</label>
                    <select name="FundCategory" class="form-input" required>
                        <option value="Tithe">Tithe</option>
                        <option value="Offering">Offering</option>
                        <option value="Mission Fund">Mission Fund</option>
                        <option value="Building Fund">Building Fund</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div style="margin-bottom:20px;">
                    <label style="font-size:11px; color:var(--gold-muted); text-transform:uppercase; display:block; margin-bottom:8px;">Donation Method</label>
                    <select name="PaymentMethod" class="form-input" required>
                        <option value="In Person">In Person</option>
                        <option value="Online Transfer">Online Transfer</option>
                        <option value="Check">Check</option>
                    </select>
                </div>

                <div style="margin-bottom:24px;">
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer; color:var(--gold-muted); font-size:13px;">
                        <input type="checkbox" name="is_anonymous" value="1" style="accent-color:var(--gold-bright);">
                        Donate Anonymously
                    </label>
                </div>
                
                <button type="submit" class="btn btn-gold" style="width:100%;">Complete Donation</button>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra_js'); ?>
<script>
    function openDonateModal() { document.getElementById('donateModal').style.display = 'flex'; }
    function closeDonateModal() { document.getElementById('donateModal').style.display = 'none'; }
    
    // Close modal on outside click
    document.getElementById('donateModal').addEventListener('click', (e) => {
        if(e.target === document.getElementById('donateModal')) closeDonateModal();
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('member.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Desktop\laravel\churchmgt\resources\views\member\donations.blade.php ENDPATH**/ ?>