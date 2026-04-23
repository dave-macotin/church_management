@extends('staff.layout.app')
@section('title', 'Event Details — Grace Church Staff')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('staff.events.index') }}" class="btn btn-ghost" style="padding:0.4rem 0.8rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        Back to List
    </a>
    <div>
        <h1 class="font-cinzel text-xl font-semibold" style="color:var(--gold-mid)">Event Details</h1>
        <p class="text-sm" style="color:var(--gold-muted)">{{ $event->Title }}</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-1 space-y-6">
        <div class="card overflow-hidden">
            @if($event->image)
                <img src="{{ asset('storage/' . $event->image) }}" class="w-full h-48 object-cover">
            @else
                <div class="w-full h-48 flex items-center justify-center bg-panel text-gold/20">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" class="w-20 h-20"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                </div>
            @endif
            <div class="p-6">
                <h2 class="text-xl font-bold mb-4" style="color:var(--gold-mid)">{{ $event->Title }}</h2>
                <div class="space-y-4">
                    <div>
                        <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Status</label>
                        <div class="mt-1">
                            @if(!$event->is_approved)
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase" style="background:rgba(250,199,117,0.12); color:#FAC775;">Pending Approval</span>
                            @elseif($event->StartDateTime && $event->StartDateTime->isFuture())
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase" style="background:rgba(93,202,165,0.12); color:#5DCAA5;">Upcoming</span>
                            @else
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase" style="background:rgba(255,255,255,0.05); color:var(--text-muted);">Past</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Location</label>
                        <div class="text-sm">{{ $event->Location ?? 'No location set' }}</div>
                    </div>
                    <div>
                        <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Start Time</label>
                        <div class="text-sm font-medium">{{ $event->StartDateTime?->format('F d, Y — g:i A') ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">End Time</label>
                        <div class="text-sm font-medium">{{ $event->EndDateTime?->format('F d, Y — g:i A') ?? 'N/A' }}</div>
                    </div>
                </div>
                
                <div class="mt-6">
                     <a href="{{ route('staff.events.edit', $event) }}" class="btn btn-gold w-full text-xs">Edit Event</a>
                </div>
            </div>
        </div>
    </div>

    <div class="md:col-span-2 space-y-6">
        <div class="card overflow-hidden">
            <div class="panel-header">
                <h3 class="panel-title">Linked Groups ({{ $event->groups->count() }})</h3>
            </div>
             <table class="w-full text-left">
                <thead>
                    <tr style="background:var(--bg-panel); color:var(--gold-mid); font-size:11px; text-transform:uppercase;">
                        <th class="p-4">Group Name</th>
                        <th class="p-4">Description</th>
                        <th class="p-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($event->groups as $group)
                        <tr>
                            <td class="p-4 font-medium text-sm">{{ $group->GroupName }}</td>
                            <td class="p-4 text-xs text-muted">{{ Str::limit($group->Description, 50) }}</td>
                            <td class="p-4 text-right">
                                <a href="{{ route('staff.groups.show', $group) }}" class="text-gold text-xs hover:underline">View Group</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card overflow-hidden">
            <div class="panel-header">
                <h3 class="panel-title">Attendance Summary</h3>
            </div>
            <div class="p-6 text-center">
                 @php $presentCount = $event->attendance->where('Status', 'Present')->count(); @endphp
                 <div class="text-4xl font-bold text-gold mb-2">{{ $presentCount }}</div>
                 <div class="text-xs uppercase tracking-widest text-muted">Total Checked In</div>
                 <div class="mt-6">
                      <a href="{{ route('staff.attendance.index', ['date' => $event->StartDateTime?->format('Y-m-d')]) }}" class="btn btn-ghost text-xs">View Full Attendance List</a>
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection
