@extends('staff.layout.app')
@section('title', 'Staff Dashboard — ' . App\Models\Setting::get('church_name', 'Grace Church'))
@section('page_title', 'Staff Dashboard')

@section('content')
<div class="space-y-8">
    {{-- Welcome Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Welcome back, {{ explode(' ', auth()->user()->name)[0] }}</h1>
            <p class="text-sm" style="color:var(--text-muted)">Here's what's happening in the ministry today.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('staff.attendance.create') }}" class="btn btn-gold">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Log Attendance
            </a>
            <a href="{{ route('staff.checkin.kiosk') }}" class="btn btn-ghost">
               <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
               Check-In Kiosk
            </a>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        <div class="card p-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full flex items-center justify-center bg-gold/10 text-gold-bright">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-widest font-bold" style="color:var(--gold-muted)">Total Members</p>
                <p class="text-2xl font-cinzel">{{ number_format($totalMembers) }}</p>
            </div>
        </div>

        <div class="card p-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full flex items-center justify-center bg-green/10 text-green">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-widest font-bold" style="color:var(--gold-muted)">Attendance Today</p>
                <p class="text-2xl font-cinzel">{{ number_format($todayAttendance) }}</p>
            </div>
        </div>

        <div class="card p-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full flex items-center justify-center bg-blue/10 text-blue">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-widest font-bold" style="color:var(--gold-muted)">Upcoming Events</p>
                <p class="text-2xl font-cinzel">{{ number_format($upcomingEvents) }}</p>
            </div>
        </div>

        <div class="card p-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full flex items-center justify-center bg-amber/10 text-amber">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-widest font-bold" style="color:var(--gold-muted)">Total Giving</p>
                <p class="text-2xl font-cinzel">${{ number_format($totalDonations) }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        {{-- Next Events --}}
        <div class="card overflow-hidden">
            <div class="panel-header">
                <h3 class="panel-title">Upcoming Events</h3>
                <a href="{{ route('staff.events.index') }}" class="text-[10px] uppercase font-bold text-gold opacity-60 hover:opacity-100 transition-opacity">View All</a>
            </div>
            <div class="p-0">
                <table class="w-full text-left text-sm">
                    <tbody class="divide-y divide-white/5">
                        @forelse($nextEvents as $event)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="p-4">
                                    <div class="font-bold text-cream">{{ $event->Title }}</div>
                                    <div class="text-[10px] text-muted">{{ $event->Location }}</div>
                                </td>
                                <td class="p-4 text-xs text-muted">
                                    {{ $event->StartDateTime ? $event->StartDateTime->format('M d, g:i A') : '—' }}
                                </td>
                                <td class="p-4 text-right">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase" style="background:rgba(93,202,165,0.12); color:#5DCAA5;">Upcoming</span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="p-8 text-center text-muted">No upcoming events</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recent Attendance --}}
        <div class="card overflow-hidden">
            <div class="panel-header">
                <h3 class="panel-title">Recent Attendance</h3>
                <a href="{{ route('staff.attendance.index') }}" class="text-[10px] uppercase font-bold text-gold opacity-60 hover:opacity-100 transition-opacity">View All</a>
            </div>
            <div class="p-0">
                <table class="w-full text-left text-sm">
                    <tbody class="divide-y divide-white/5">
                        @forelse($recentAttendance as $att)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="p-4">{{ $att->member_name }}</td>
                                <td class="p-4 text-xs text-muted">
                                    {{ $att->Timestamp ? \Carbon\Carbon::parse($att->Timestamp)->format('M d, g:i A') : '—' }}
                                </td>
                                <td class="p-4 text-right">
                                    @if($att->Status === 'Present')
                                        <span class="text-[10px] font-bold text-[#5DCAA5] uppercase">Present</span>
                                    @else
                                        <span class="text-[10px] font-bold text-[#FAC775] uppercase">{{ $att->Status }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="p-8 text-center text-muted">No recent logs</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection