@extends('member.layout.app')
@section('title', 'Volunteer Opportunities — ' . App\Models\Setting::get('church_name', 'Grace Church'))
@section('page_title', 'Serve the Community')

@section('content')
<div class="mb-8 p-8 card bg-gradient-to-br from-bg-card to-bg-hover border-l-4" style="border-left-color: var(--gold)">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Call to Service</h1>
            <p class="text-sm mt-1" style="color:var(--text-muted)">"Each of you should use whatever gift you have received to serve others..." — 1 Peter 4:10</p>
        </div>
        <div class="flex gap-4">
            <div class="text-center">
                <div class="text-2xl font-cinzel text-main">{{ count($opportunities) }}</div>
                <div class="text-[10px] uppercase font-bold text-muted">Open Roles</div>
            </div>
            <div class="border-r border-white/10"></div>
            <div class="text-center">
                <div class="text-2xl font-cinzel text-main">{{ count($myRegistrations) }}</div>
                <div class="text-[10px] uppercase font-bold text-muted">My Signups</div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($opportunities as $opp)
        <div class="card p-6 flex flex-col h-full border-t-2 {{ in_array($opp->id, $myRegistrations) ? 'border-green-500' : 'border-gold/30' }}">
            <div class="flex justify-between items-start mb-4">
                <div class="px-2 py-1 rounded bg-gold/10 border border-gold/20 text-[10px] font-bold uppercase text-gold">
                    {{ $opp->category ?? 'General' }}
                </div>
                @if(in_array($opp->id, $myRegistrations))
                    <div class="px-2 py-1 rounded bg-green-500/10 border border-green-500/40 text-[10px] font-bold uppercase text-green-500">
                        Signed Up
                    </div>
                @endif
            </div>

            <h3 class="font-cinzel text-lg mb-2" style="color:var(--gold-mid)">{{ $opp->title }}</h3>
            <p class="text-xs mb-6 flex-1 opacity-70 leading-relaxed">{{ $opp->description }}</p>

            <div class="space-y-2 mb-6 text-xs" style="color:var(--text-muted)">
                <div class="flex justify-between">
                    <span>Date:</span>
                    <span class="text-main font-semibold">{{ $opp->date ? \Carbon\Carbon::parse($opp->date)->format('M d, Y') : 'Ongoing' }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Shift:</span>
                    <span class="text-main font-semibold">{{ $opp->time_slot ?? 'Flexible' }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Positions:</span>
                    <span class="text-main font-semibold text-gold">{{ $opp->needed_volunteers }} needed</span>
                </div>
            </div>

            @if(!in_array($opp->id, $myRegistrations))
                <form method="POST" action="{{ route('member.volunteering.signup', $opp->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-gold w-full py-2.5 h-auto text-xs uppercase font-bold tracking-widest">Sign Up to Serve</button>
                </form>
            @else
                <button disabled class="btn btn-ghost w-full py-2.5 h-auto text-xs uppercase font-bold tracking-widest opacity-50 cursor-not-allowed">Application Pending</button>
            @endif
        </div>
    @empty
        <div class="col-span-full py-20 text-center card">
            <div class="text-5xl mb-4 opacity-20">🤝</div>
            <p style="color:var(--gold-muted)">No active volunteer opportunities at the moment.</p>
        </div>
    @endforelse
</div>
@endsection
