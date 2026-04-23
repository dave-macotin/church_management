@extends('member.layout.app')

@section('title', 'My Donations')
@section('page_title', 'My Giving')

@section('extra_css')
<style>
    .giving-section { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }
    .stat-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px; position: relative; overflow: hidden; }
    .stat-card.gold::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 2px; background: linear-gradient(90deg, var(--gold-bright), transparent); }
    .stat-card.green::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 2px; background: linear-gradient(90deg, var(--green), transparent); }
</style>
@endsection

@section('content')
    {{-- Top Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card p-6 flex flex-col justify-center border-l-4 border-gold-bright">
            <div class="text-[10px] font-bold text-gold-muted uppercase tracking-widest mb-1">Total Contributions</div>
            <div class="font-cinzel text-2xl font-bold text-gold-bright">₱{{ number_format($totalDonations, 2) }}</div>
        </div>
        <div class="card p-6 flex flex-col justify-center border-l-4 border-gold-muted/30">
            <div class="text-[10px] font-bold text-gold-muted uppercase tracking-widest mb-1">Giving Instances</div>
            <div class="font-cinzel text-2xl font-bold text-cream">{{ $donationCount }}</div>
        </div>
        <button onclick="openDonateModal()" class="card p-6 flex items-center justify-center gap-4 group hover:border-gold-bright/30 transition-all cursor-pointer bg-gold-bright/5">
            <div class="w-12 h-12 rounded-xl bg-gold-bright/10 flex items-center justify-center text-gold-bright group-hover:bg-gold-bright group-hover:text-black transition-all">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            </div>
            <div class="text-left">
                <div class="font-cinzel text-sm font-bold text-gold-bright">Donate Now</div>
                <div class="text-[10px] text-gold-muted">Support our mission</div>
            </div>
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- History Table --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="card overflow-hidden">
                <div class="data-table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Fund Category</th>
                                <th>Method</th>
                                <th class="text-right">Amount</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($donations as $donation)
                            <tr>
                                <td class="text-cream text-sm">{{ \Carbon\Carbon::parse($donation->Date)->format('M d, Y') }}</td>
                                <td><span class="badge badge-muted">{{ $donation->FundCategory }}</span></td>
                                <td class="text-gold-muted text-xs">{{ $donation->PaymentMethod ?? '—' }}</td>
                                <td class="text-right font-bold text-gold-bright">₱{{ number_format($donation->Amount, 2) }}</td>
                                <td class="text-center">
                                    <a href="{{ route('member.donations.receipt', $donation->DonationID) }}" target="_blank" class="btn btn-ghost btn-xs">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right:4px;"><path d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" stroke-width="2"/></svg>
                                        Receipt
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <h4>No Giving History</h4>
                                        <p>Your contributions will appear here once recorded.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($donations->hasPages())
                <div class="flex justify-center">
                    {{ $donations->links() }}
                </div>
            @endif
        </div>

        {{-- Breakdown --}}
        <div class="space-y-6">
            <div class="card p-6">
                <h4 class="font-cinzel text-sm font-bold text-gold-mid mb-6 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                    Giving Breakdown
                </h4>
                <div class="space-y-6">
                    @forelse($fundBreakdown as $fb)
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-[11px] font-bold text-gold-muted uppercase tracking-wider">{{ $fb['name'] }}</span>
                            <span class="text-sm font-bold text-cream">₱{{ number_format($fb['amount'], 0) }}</span>
                        </div>
                        @php $percent = $totalDonations > 0 ? ($fb['amount'] / $totalDonations) * 100 : 0; @endphp
                        <div class="h-1.5 w-full bg-white/5 rounded-full overflow-hidden">
                            <div class="h-full bg-gold-bright rounded-full transition-all duration-1000" style="width:{{ $percent }}%;"></div>
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-gold-muted italic text-center py-4">No data available</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Donate Modal --}}
    <div id="donateModal" style="display:none;" class="fixed inset-0 bg-black/80 z-[2000] backdrop-blur-sm flex items-center justify-center p-4">
        <div class="card w-full max-w-md p-8 shadow-2xl relative border-gold-bright/20">
            <button onclick="closeDonateModal()" class="absolute top-4 right-4 text-gold-muted hover:text-white transition-colors">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            
            <div class="text-center mb-8">
                <h3 class="font-cinzel text-xl text-gold-mid">Support our Ministry</h3>
                <p class="text-xs text-gold-muted mt-2">Every contribution helps spread the Gospel</p>
            </div>
            
            <form action="{{ route('member.donations.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="info-label text-[10px] uppercase font-bold text-gold-muted mb-2 block tracking-widest">Amount (₱)</label>
                    <input type="number" name="Amount" step="0.01" class="form-input text-lg font-bold text-gold-bright" placeholder="0.00" required>
                </div>
                
                <div>
                    <label class="info-label text-[10px] uppercase font-bold text-gold-muted mb-2 block tracking-widest">Fund Category</label>
                    <select name="FundCategory" class="form-input" required>
                        <option value="Tithe">Tithe</option>
                        <option value="Offering">Offering</option>
                        <option value="Mission Fund">Mission Fund</option>
                        <option value="Building Fund">Building Fund</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div>
                    <label class="info-label text-[10px] uppercase font-bold text-gold-muted mb-2 block tracking-widest">Payment Method</label>
                    <select name="PaymentMethod" class="form-input" required>
                        <option value="In Person">In Person / Cash</option>
                        <option value="Online Transfer">Online Transfer</option>
                        <option value="Check">Check</option>
                    </select>
                </div>

                <div class="flex items-center gap-3 py-2">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_anonymous" value="1" class="sr-only peer">
                        <div class="w-11 h-6 bg-white/10 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gold-bright"></div>
                        <span class="ml-3 text-xs font-medium text-gold-muted">Donate Anonymously</span>
                    </label>
                </div>
                
                <button type="submit" class="btn btn-gold w-full py-4 font-bold text-sm tracking-widest uppercase shadow-lg">Submit Donation</button>
            </form>
        </div>
    </div>
@endsection

@section('extra_js')
<script>
    function openDonateModal() { document.getElementById('donateModal').style.display = 'flex'; }
    function closeDonateModal() { document.getElementById('donateModal').style.display = 'none'; }
    
    // Close modal on outside click
    document.getElementById('donateModal').addEventListener('click', (e) => {
        if(e.target === document.getElementById('donateModal')) closeDonateModal();
    });
</script>
@endsection