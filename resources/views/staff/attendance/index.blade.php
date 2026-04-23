@extends('staff.layout.app')
@section('title', 'Attendance — Grace Church Staff')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Attendance</h1>
        <p class="text-sm mt-1" style="color:var(--text-muted)">{{ $attendances->total() }} records</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('staff.attendance.create') }}" class="btn btn-gold">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Log Attendance
        </a>
    </div>
</div>

<form method="GET" class="flex gap-3 mb-5">
    <div class="search-wrap flex-1">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by member name…" class="form-input">
    </div>
    <select name="status" class="form-input" style="width:160px">
        <option value="">All Statuses</option>
        <option value="Present" {{ request('status') === 'Present' ? 'selected' : '' }}>Present</option>
        <option value="Absent"  {{ request('status') === 'Absent'  ? 'selected' : '' }}>Absent</option>
        <option value="Excused" {{ request('status') === 'Excused' ? 'selected' : '' }}>Excused</option>
    </select>
    <input type="date" name="date" value="{{ request('date') }}" class="form-input" style="width:170px">
    <button type="submit" class="btn btn-ghost">Filter</button>
    @if(request('search') || request('status') || request('date'))
        <a href="{{ route('staff.attendance.index') }}" class="btn btn-ghost">Clear</a>
    @endif
</form>

<div class="card overflow-hidden">
    <table class="w-full text-left">
        <thead>
            <tr style="background:var(--bg-panel); color:var(--gold-mid); font-size:11px; text-transform:uppercase;">
                <th class="p-4">Member</th>
                <th class="p-4">Event</th>
                <th class="p-4">Status</th>
                <th class="p-4">Check In/Out</th>
                <th class="p-4">Log Date</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
        @forelse($attendances as $att)
            <tr>
                <td class="p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"
                             style="background:var(--bg-hover);color:var(--gold)">
                            {{ $att->member ? strtoupper(substr($att->member->FirstName,0,1).substr($att->member->LastName,0,1)) : '?' }}
                        </div>
                        <span class="font-medium text-sm">{{ $att->member ? $att->member->FirstName . ' ' . $att->member->LastName : '—' }}</span>
                    </div>
                </td>
                <td class="p-4">
                    <span class="text-sm" style="color:var(--text-muted)">{{ $att->event?->Title ?? 'Service/Gathering' }}</span>
                </td>
                <td class="p-4">
                    @if($att->Status === 'Present')
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase" style="background:rgba(93,202,165,0.12); color:#5DCAA5;">Present</span>
                    @elseif($att->Status === 'Absent')
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase" style="background:rgba(216,90,48,0.12); color:#D85A30;">Absent</span>
                    @else
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase" style="background:rgba(250,199,117,0.12); color:#FAC775;">Excused</span>
                    @endif
                </td>
                <td class="p-4">
                    @if($att->CheckInTime)
                        <div class="text-[10px]">
                            <span style="color:var(--green);font-weight:700">IN:</span> {{ $att->CheckInTime->format('g:i A') }}
                            @if($att->CheckOutTime)
                                <br><span style="color:#FAC775;font-weight:700">OUT:</span> {{ $att->CheckOutTime->format('g:i A') }}
                            @endif
                        </div>
                    @else
                        <span class="text-xs" style="color:var(--text-muted);font-style:italic">No logs</span>
                    @endif
                </td>
                <td class="p-4 text-xs text-muted">{{ $att->Timestamp?->format('M d, Y') ?? '—' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center py-12" style="color:var(--text-muted)">
                    No attendance records found
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="flex justify-end mt-4 pagination">{{ $attendances->links() }}</div>
@endsection
