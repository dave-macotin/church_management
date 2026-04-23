@extends('admin.Layout.app')
@section('title', 'Admin Dashboard — ' . App\Models\Setting::get('church_name', 'Grace Church'))

@section('content')
<div class="mb-8">
    <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Dashboard</h1>
    <p class="text-sm mt-1" style="color:var(--text-muted)">Welcome back, Admin. Here is what's happening today.</p>
</div>

{{-- Top Stats --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6 border-l-4" style="border-left-color: var(--amber);">
        <div class="text-[10px] uppercase font-bold tracking-widest mb-1" style="color:var(--text-muted)">Total Members</div>
        <div class="text-3xl font-cinzel tracking-tight" style="color:var(--gold)">{{ number_format($totalMembers) }}</div>
        <div class="text-[10px] mt-2 flex items-center gap-1" style="color:var(--green)">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 15l7-7 7 7"/></svg>
            <span>Active Community</span>
        </div>
    </div>

    <div class="card p-6 border-l-4" style="border-left-color: var(--green);">
        <div class="text-[10px] uppercase font-bold tracking-widest mb-1" style="color:var(--text-muted)">Total Donations</div>
        <div class="text-3xl font-cinzel tracking-tight" style="color:var(--green)">₱{{ number_format($totalDonations, 0) }}</div>
        <div class="text-[10px] mt-2 flex items-center gap-1 text-white opacity-60">
            <span>All-time contributions</span>
        </div>
    </div>

    <div class="card p-6 border-l-4" style="border-left-color: var(--gold);">
        <div class="text-[10px] uppercase font-bold tracking-widest mb-1" style="color:var(--text-muted)">Upcoming Events</div>
        <div class="text-3xl font-cinzel tracking-tight" style="color:var(--text-main)">{{ $upcomingEvents }}</div>
        <div class="text-[10px] mt-2 text-white opacity-60">Scheduled activities</div>
    </div>

    <div class="card p-6 border-l-4" style="border-left-color: var(--red);">
        <div class="text-[10px] uppercase font-bold tracking-widest mb-1" style="color:var(--text-muted)">Total Expenses</div>
        <div class="text-3xl font-cinzel tracking-tight" style="color:var(--red)">₱{{ number_format($totalExpenses, 0) }}</div>
        <div class="text-[10px] mt-2 text-white opacity-60">Total operational spend</div>
    </div>
</div>

{{-- Charts Row --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="card p-6">
        <h3 class="font-cinzel text-sm mb-6 uppercase tracking-widest" style="color:var(--gold)">Giving Analytics (Last 6 Months)</h3>
        <canvas id="givingChart" height="200"></canvas>
    </div>
    <div class="card p-6">
        <h3 class="font-cinzel text-sm mb-6 uppercase tracking-widest" style="color:var(--gold)">Attendance Trends</h3>
        <canvas id="attendanceChart" height="200"></canvas>
    </div>
</div>

{{-- Recent Data Row --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    {{-- Recent Members --}}
    <div class="card col-span-1">
        <div class="p-5 border-b flex justify-between items-center" style="border-color:var(--border)">
            <h3 class="font-cinzel text-xs uppercase tracking-widest" style="color:var(--gold)">New Members</h3>
            <a href="{{ route('admin.members.index') }}" class="text-[10px] uppercase font-bold hover:underline" style="color:var(--text-muted)">View All</a>
        </div>
        <div class="p-2">
            @forelse($recentMembers as $member)
                <div class="flex items-center gap-3 p-3 hover:bg-white/5 rounded-lg transition-colors">
                    <div class="w-8 h-8 rounded-full bg-amber-900/40 flex items-center justify-center text-xs font-bold" style="color:var(--gold)">
                        {{ substr($member->FirstName, 0, 1) }}{{ substr($member->LastName, 0, 1) }}
                    </div>
                    <div>
                        <div class="text-sm font-semibold">{{ $member->FirstName }} {{ $member->LastName }}</div>
                        <div class="text-[10px]" style="color:var(--text-muted)">Joined {{ $member->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            @empty
                <p class="p-5 text-sm text-center text-muted">No recent members</p>
            @endforelse
        </div>
    </div>

    {{-- Upcoming Events --}}
    <div class="card col-span-1">
        <div class="p-5 border-b flex justify-between items-center" style="border-color:var(--border)">
            <h3 class="font-cinzel text-xs uppercase tracking-widest" style="color:var(--gold)">Upcoming Events</h3>
            <a href="{{ route('admin.events.index') }}" class="text-[10px] uppercase font-bold hover:underline" style="color:var(--text-muted)">View All</a>
        </div>
        <div class="p-2">
            @forelse($nextEvents as $event)
                <div class="flex items-center gap-3 p-3 border-b border-white/5 last:border-0">
                    <div class="text-center bg-white/5 p-2 rounded min-w-[50px]">
                        <div class="text-xs font-bold uppercase" style="color:var(--gold)">{{ $event->StartDateTime->format('M') }}</div>
                        <div class="text-lg font-cinzel">{{ $event->StartDateTime->format('d') }}</div>
                    </div>
                    <div>
                        <div class="text-sm font-semibold">{{ $event->Title }}</div>
                        <div class="text-[10px]" style="color:var(--text-muted)">{{ $event->Location }}</div>
                    </div>
                </div>
            @empty
                <p class="p-5 text-sm text-center text-muted">No upcoming events</p>
            @endforelse
        </div>
    </div>

    {{-- Recent Donations --}}
    <div class="card col-span-1">
        <div class="p-5 border-b flex justify-between items-center" style="border-color:var(--border)">
            <h3 class="font-cinzel text-xs uppercase tracking-widest" style="color:var(--gold)">Recent Giving</h3>
            <a href="{{ route('admin.donations.index') }}" class="text-[10px] uppercase font-bold hover:underline" style="color:var(--text-muted)">View All</a>
        </div>
        <div class="p-2">
            @forelse($recentDonations as $donation)
                <div class="flex items-center justify-between p-3 border-b border-white/5 last:border-0">
                    <div>
                        <div class="text-sm font-semibold">{{ $donation->FundCategory }}</div>
                        <div class="text-[10px]" style="color:var(--text-muted)">{{ $donation->Date->format('M d, Y') }}</div>
                    </div>
                    <div class="text-sm font-bold" style="color:var(--green)">+₱{{ number_format($donation->Amount, 2) }}</div>
                </div>
            @empty
                <p class="p-5 text-sm text-center text-muted">No recent donations</p>
            @endforelse
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Giving Chart
    const givingCtx = document.getElementById('givingChart').getContext('2d');
    new Chart(givingCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($monthlyGiving->pluck('month')) !!},
            datasets: [{
                label: 'Monthly Giving (₱)',
                data: {!! json_encode($monthlyGiving->pluck('total')) !!},
                backgroundColor: 'rgba(200, 134, 10, 0.6)',
                borderColor: 'rgba(200, 134, 10, 1)',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#9a7a65' } },
                x: { grid: { display: false }, ticks: { color: '#9a7a65' } }
            },
            plugins: { legend: { display: false } }
        }
    });

    // Attendance Chart
    const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
    new Chart(attendanceCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($attendanceTrends->pluck('month')) !!},
            datasets: [{
                label: 'Attendance',
                data: {!! json_encode($attendanceTrends->pluck('total')) !!},
                borderColor: '#e6a020',
                backgroundColor: 'rgba(230, 160, 32, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#e6a020'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#9a7a65' } },
                x: { grid: { display: false }, ticks: { color: '#9a7a65' } }
            },
            plugins: { legend: { display: false } }
        }
    });
</script>
@endsection
