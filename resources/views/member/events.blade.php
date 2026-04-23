@extends('member.layout.app')

@section('title', 'Church Events')
@section('page_title', 'Church Events')

@section('extra_css')
<style>
    .events-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 24px; }
    .event-card { transition: transform 0.2s, border-color 0.2s; position: relative; overflow: hidden; }
    .event-card:hover { transform: translateY(-5px); border-color: rgba(239, 159, 39, 0.4); }
    .event-banner { height: 120px; background: linear-gradient(135deg, #2a160a 0%, #1a0f05 100%); position: relative; display: flex; align-items: center; justify-content: center; overflow: hidden; }
    .event-banner::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 1px; background: var(--border); }
    .event-type-badge { position: absolute; top: 12px; right: 12px; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); color: var(--gold-mid); font-size: 10px; padding: 4px 10px; border-radius: 99px; border: 1px solid var(--border); }
    .event-body { padding: 20px; }
    .event-date { font-weight: 700; color: var(--gold-bright); font-family: Georgia, serif; font-size: 13px; margin-bottom: 8px; text-transform: uppercase; }
    .event-h3 { font-family: Georgia, serif; font-size: 18px; color: var(--cream); margin-bottom: 12px; }
    .event-loc { font-size: 13px; color: var(--gold-muted); display: flex; align-items: center; gap: 6px; margin-bottom: 20px; }
</style>
@endsection

@section('content')
<div style="margin-bottom:48px;">
    <h3 class="font-cinzel text-xl mb-8 flex items-center gap-3 text-gold-mid">
        <svg style="width:24px;height:24px" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        Upcoming Events
    </h3>

    <div class="events-grid">
        @forelse($upcomingEvents as $event)
        <div class="card event-card flex flex-col">
            <div class="event-banner">
                <svg style="width:56px; height:56px; opacity:0.15; color:var(--gold-bright);" fill="currentColor" viewBox="0 0 24 24"><path d="M19 4H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-7 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm6 12H6v-1c0-2 4-3.1 6-3.1s6 1.1 6 3.1v1z"/></svg>
                <div class="badge badge-muted" style="position:absolute; top:12px; right:12px; background:rgba(0,0,0,0.6); backdrop-filter:blur(4px);">Church Event</div>
            </div>
            <div class="event-body flex-1 flex flex-col p-6">
                <div class="text-[11px] font-bold text-gold-bright uppercase tracking-wider mb-2 flex items-center gap-2">
                    <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2"/></svg>
                    {{ $event->StartDateTime->format('M d, Y') }} • {{ $event->StartDateTime->format('g:i A') }}
                </div>
                <h3 class="font-cinzel text-lg text-cream mb-3 leading-snug">{{ $event->Title }}</h3>
                <div class="text-sm text-gold-muted flex items-center gap-2 mb-6">
                    <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/></svg>
                    {{ $event->Location ?? 'Grace Church' }}
                </div>

                <div class="mt-auto pt-5 border-t border-white/5">
                    @php 
                        $isRegistered = in_array($event->EventID, $registeredEventIds); 
                        $attendance = $eventAttendances[$event->EventID] ?? null;
                    @endphp
                    
                    @if($isRegistered)
                        @if(!$attendance || !$attendance->CheckInTime)
                            <div class="flex flex-col gap-3">
                                <div class="flex justify-between items-center bg-gold-bright/5 p-3 rounded-lg border border-gold-bright/10">
                                    <span class="text-xs font-bold text-green-400 flex items-center gap-2">
                                        <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/></svg>
                                        REGISTERED
                                    </span>
                                    <form action="{{ route('member.events.cancel', $event->EventID) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-[10px] uppercase font-bold text-red-400 opacity-60 hover:opacity-100 transition-opacity">Cancel</button>
                                    </form>
                                </div>
                                <form action="{{ route('member.events.checkin', $event->EventID) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-gold w-full flex items-center justify-center gap-2 py-2.5">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Check In Now
                                    </button>
                                </form>
                            </div>
                        @elseif(!$attendance->CheckOutTime)
                            <div class="flex flex-col gap-3">
                                <div class="flex flex-col gap-1 p-3 rounded-lg border border-green-500/20 bg-green-500/5">
                                    <div class="text-[10px] font-bold text-green-400 uppercase tracking-widest flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-green-400 shadow-[0_0_8px_rgba(74,222,128,0.5)] animate-pulse"></span>
                                        Now Attending
                                    </div>
                                    <div class="text-xs text-cream/70">Joined at {{ $attendance->CheckInTime->format('g:i A') }}</div>
                                </div>
                                <form action="{{ route('member.events.checkout', $event->EventID) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-ghost w-full py-2.5 text-red-400 border-red-500/20 bg-red-500/5 hover:bg-red-500/10 transition-colors flex items-center justify-center gap-2">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        End Attendance
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="p-4 rounded-xl bg-gold-bright/5 border border-white/5 flex flex-col gap-3">
                                <div class="text-[10px] font-bold text-gold-muted uppercase tracking-widest flex items-center gap-2">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Attendance Logged
                                </div>
                                <div class="flex justify-between items-center text-[11px] text-cream/60">
                                    <span>{{ $attendance->CheckInTime->format('g:i A') }}</span>
                                    <svg class="w-4 h-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 12H7m10 0l-4-4m4 4l-4 4" stroke-width="2"/></svg>
                                    <span>{{ $attendance->CheckOutTime->format('g:i A') }}</span>
                                </div>
                            </div>
                        @endif
                    @else
                        <form action="{{ route('member.events.join', $event->EventID) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-gold w-full py-3 font-bold tracking-wide">Register for Event</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h4>No Upcoming Events</h4>
                <p>New events will appear here when scheduled. Join us for our next gathering!</p>
            </div>
        </div>
        @endforelse
    </div>
</div>

@if($pastEvents->count() > 0)
<div>
    <h3 class="font-cinzel text-lg mb-6 text-gold-muted">Recent History</h3>
    <div class="card overflow-hidden">
        <div class="data-table-container">
            <table>
                <thead>
                    <tr>
                        <th>Event Title</th>
                        <th>Date</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pastEvents as $event)
                    <tr>
                        <td class="font-medium text-cream">{{ $event->Title }}</td>
                        <td class="text-gold-muted">{{ $event->StartDateTime->format('M d, Y') }}</td>
                        <td class="text-gold-muted">{{ $event->Location ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-6 flex justify-center">
        {{ $pastEvents->links() }}
    </div>
</div>
@endif
@endsection
