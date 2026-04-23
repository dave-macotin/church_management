@extends('staff.layout.app')
@section('title', 'Member Details — Grace Church Staff')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('staff.members.index') }}" class="btn btn-ghost" style="padding:0.4rem 0.8rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        Back to List
    </a>
    <div>
        <h1 class="font-cinzel text-xl font-semibold" style="color:var(--gold-mid)">Member Profile</h1>
        <p class="text-sm" style="color:var(--gold-muted)">{{ $member->FirstName }} {{ $member->LastName }}</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-1 space-y-6">
        <div class="card p-6 text-center">
            <div class="w-24 h-24 rounded-full mx-auto mb-4 border-2 border-gold flex items-center justify-center text-2xl font-bold bg-panel" style="color:var(--gold)">
                @if($member->profile_picture)
                    <img src="{{ asset('storage/' . $member->profile_picture) }}" class="w-full h-full rounded-full object-cover">
                @else
                    {{ strtoupper(substr($member->FirstName, 0, 1) . substr($member->LastName, 0, 1)) }}
                @endif
            </div>
            <h2 class="text-xl font-bold" style="color:var(--gold-mid)">{{ $member->FirstName }} {{ $member->LastName }}</h2>
            <p class="text-sm" style="color:var(--gold-muted)">{{ $member->role?->RoleName ?? 'Member' }}</p>
            
            <div class="mt-4 flex flex-wrap justify-center gap-2">
                @if($member->Status === 'Active')
                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase" style="background:rgba(93,202,165,0.12); color:#5DCAA5;">Active</span>
                @else
                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase" style="background:rgba(216,90,48,0.12); color:#D85A30;">{{ $member->Status }}</span>
                @endif
            </div>
        </div>

        <div class="card p-6">
            <h3 class="text-sm font-bold uppercase tracking-wider mb-4" style="color:var(--gold-muted)">Contact Details</h3>
            <div class="space-y-4">
                <div>
                    <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Email</label>
                    <div class="text-sm">{{ $member->Email ?? 'No email provided' }}</div>
                </div>
                <div>
                    <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Phone</label>
                    <div class="text-sm">{{ $member->PhoneNumber ?? 'No phone provided' }}</div>
                </div>
                <div>
                    <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Family</label>
                    <div class="text-sm">
                        @if($member->family)
                            <a href="{{ route('staff.families.show', $member->family) }}" class="text-gold hover:underline">{{ $member->family->FamilyName }}</a>
                        @else
                            No family assigned
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="md:col-span-2 space-y-6">
        <div class="card overflow-hidden">
            <div class="panel-header">
                <h3 class="panel-title">Recent Attendance</h3>
            </div>
            <table class="w-full text-left">
                <thead>
                    <tr style="background:var(--bg-panel); color:var(--gold-mid); font-size:11px; text-transform:uppercase;">
                        <th class="p-4">Date</th>
                        <th class="p-4">Event</th>
                        <th class="p-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($member->attendances as $attendance)
                        <tr>
                            <td class="p-4 text-sm">{{ $attendance->Timestamp->format('M d, Y') }}</td>
                            <td class="p-4 text-sm">{{ $attendance->event?->Title ?? 'General' }}</td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase" 
                                      style="background:{{ $attendance->Status === 'Present' ? 'rgba(93,202,165,0.12)' : 'rgba(216,90,48,0.12)' }}; 
                                             color:{{ $attendance->Status === 'Present' ? '#5DCAA5' : '#D85A30' }};">
                                    {{ $attendance->Status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-8 text-center text-sm" style="color:var(--gold-muted)">No attendance records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
