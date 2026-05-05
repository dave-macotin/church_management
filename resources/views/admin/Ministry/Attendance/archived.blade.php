@extends('admin.layout.app')
@section('title', 'Archived Attendance — Grace Church CMS')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Archived Attendance</h1>
        <p class="text-sm mt-1" style="color:var(--text-muted)">{{ $attendances->total() }} archived records</p>
    </div>
    <a href="{{ route('admin.attendance.index') }}" class="btn btn-ghost">← Back to Active</a>
</div>

<div class="card overflow-hidden">
    <table>
        <thead>
            <tr>
                <th>Member</th>
                <th>Event</th>
                <th>Status</th>
                <th>Archived On</th>
                <th style="text-align:right">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($attendances as $att)
            <tr style="opacity:0.75">
                <td>
                    <span class="font-medium">{{ $att->member ? $att->member->FirstName . ' ' . $att->member->LastName : '—' }}</span>
                </td>
                <td style="color:var(--text-muted)">{{ $att->event?->Title ?? 'Service/Gathering' }}</td>
                <td>
                    @if($att->Status === 'Present')
                        <span class="badge badge-green">Present</span>
                    @elseif($att->Status === 'Absent')
                        <span class="badge badge-red">Absent</span>
                    @else
                        <span class="badge badge-amber">Excused</span>
                    @endif
                </td>
                <td style="color:var(--text-muted)">{{ $att->deleted_at->format('M d, Y') }}</td>
                <td style="text-align:right">
                    <form method="POST" action="{{ route('admin.attendance.restore', $att->AttendanceID) }}">
                        @csrf
                        <button type="submit" class="btn btn-ghost" style="padding:0.35rem 0.7rem;font-size:0.8rem;color:var(--green);border-color:var(--green)">Restore</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center py-12" style="color:var(--text-muted)">No archived records.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="flex justify-end mt-4 pagination">{{ $attendances->links() }}</div>
@endsection
