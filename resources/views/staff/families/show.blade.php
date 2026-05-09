@extends('staff.layout.app')
@section('title', 'Family Details — Grace Church Staff')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('staff.families.index') }}" class="btn btn-ghost" style="padding:0.4rem 0.8rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        Back to List
    </a>
    <div>
        <h1 class="font-cinzel text-xl font-semibold" style="color:var(--gold-mid)">Family Profile</h1>
        <p class="text-sm" style="color:var(--gold-muted)">{{ $family->FamilyName }} Family</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-1 space-y-6">
        <div class="card p-6">
            <h2 class="text-xl font-bold mb-4" style="color:var(--gold-mid)">{{ $family->FamilyName }}</h2>
            <div class="space-y-4">
                <div>
                    <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Head of Family</label>
                    <div class="text-sm">
                        @if($family->headMember)
                            <a href="{{ route('staff.members.show', $family->headMember) }}" class="text-gold hover:underline">{{ $family->headMember->FirstName }} {{ $family->headMember->LastName }}</a>
                        @else
                            Not set
                        @endif
                    </div>
                </div>
                <div>
                    <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Home Address</label>
                    <div class="text-sm">{{ $family->HomeAddress ?? 'No address provided' }}</div>
                </div>
                <div>
                    <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Phone Number</label>
                    <div class="text-sm">{{ $family->PhoneNumber ?? 'No phone provided' }}</div>
                </div>
            </div>
            
        </div>
    </div>

    <div class="md:col-span-2 space-y-6">
        <div class="card overflow-hidden">
            <div class="panel-header">
                <h3 class="panel-title">Family Members ({{ $family->members->count() }})</h3>
            </div>
            <table class="w-full text-left">
                <thead>
                    <tr style="background:var(--bg-panel); color:var(--gold-mid); font-size:11px; text-transform:uppercase;">
                        <th class="p-4">Name</th>
                        <th class="p-4">Role</th>
                        <th class="p-4">Status</th>
                        <th class="p-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($family->members as $fmember)
                        <tr>
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-[10px] font-bold bg-panel" style="color:var(--gold)">
                                        {{ strtoupper(substr($fmember->FirstName, 0, 1) . substr($fmember->LastName, 0, 1)) }}
                                    </div>
                                    <span class="text-sm font-medium">{{ $fmember->FirstName }} {{ $fmember->LastName }}</span>
                                </div>
                            </td>
                            <td class="p-4 text-xs text-muted">{{ $fmember->role?->RoleName ?? 'Member' }}</td>
                            <td class="p-4 text-xs">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase" 
                                      style="background:{{ $fmember->Status === 'Active' ? 'rgba(93,202,165,0.12)' : 'rgba(216,90,48,0.12)' }}; 
                                             color:{{ $fmember->Status === 'Active' ? '#5DCAA5' : '#D85A30' }};">
                                    {{ $fmember->Status }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('staff.members.show', $fmember) }}" class="text-gold text-xs hover:underline">View Profile</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
