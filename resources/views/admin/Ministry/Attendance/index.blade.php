@extends('admin.layout.app')
@section('title', 'Attendance — Grace Church CMS')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Attendance</h1>
        <p class="text-sm mt-1" style="color:var(--text-muted)">{{ $attendances->total() }} records</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.attendance.archived') }}" class="btn btn-ghost" style="font-size:0.8rem">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
            View Archived
        </a>
        <a href="{{ route('admin.attendance.create') }}" class="btn btn-gold">
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
        <a href="{{ route('admin.attendance.index') }}" class="btn btn-ghost">Clear</a>
    @endif
</form>

<div class="card overflow-hidden">
    <div class="data-table-container">
        <table>
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Event</th>
                    <th>Status</th>
                    <th>Check In/Out</th>
                    <th>Log Date</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($attendances as $att)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="user-avatar" 
                                 style="{{ $att->member?->profile_picture ? 'background-image:url('.asset('storage/'.$att->member->profile_picture).'); color:transparent;' : 'background:var(--bg-hover);color:var(--gold-mid);' }}">
                                @if(!$att->member?->profile_picture)
                                    {{ $att->member ? strtoupper(substr($att->member->FirstName,0,1).substr($att->member->LastName,0,1)) : '?' }}
                                @endif
                            </div>
                            <span class="font-medium">{{ $att->member ? $att->member->FirstName . ' ' . $att->member->LastName : '—' }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="text-sm" style="color:var(--gold-muted)">{{ $att->event?->Title ?? 'Service/Gathering' }}</span>
                    </td>
                    <td>
                        @if($att->Status === 'Present')
                            <span class="badge badge-green">Present</span>
                        @elseif($att->Status === 'Absent')
                            <span class="badge badge-red">Absent</span>
                        @else
                            <span class="badge badge-amber">Excused</span>
                        @endif
                    </td>
                    <td>
                        @if($att->CheckInTime)
                            <div class="text-xs">
                                <span style="color:var(--green);font-weight:700">In:</span> {{ $att->CheckInTime->format('g:i A') }}
                                @if($att->CheckOutTime)
                                    <br><span style="color:var(--amber);font-weight:700">Out:</span> {{ $att->CheckOutTime->format('g:i A') }}
                                @endif
                            </div>
                        @else
                            <span class="text-xs italic" style="color:var(--gold-muted)">No time logs</span>
                        @endif
                    </td>
                    <td style="color:var(--gold-muted)">{{ $att->Timestamp?->format('M d, Y') ?? '—' }}</td>
                    <td>
                        <div class="flex items-center gap-2 justify-end">
                            <form method="POST" action="{{ route('admin.attendance.archive', $att) }}"
                                  onsubmit="return confirm('Archive this attendance record?')">
                                @csrf
                                <button type="submit" class="btn btn-ghost btn-sm" style="color:var(--gold-bright); border-color:rgba(239, 159, 39, 0.2)"
                                        title="Archive this record">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                                    Archive
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h4>No Attendance Records</h4>
                            <p>No presence logs found for the selected filters.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="flex justify-end mt-4 pagination">{{ $attendances->links() }}</div>
@endsection
