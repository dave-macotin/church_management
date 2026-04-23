@extends('member.layout.app')

@section('title', 'Attendance History')
@section('page_title', 'Attendance History')

@section('content')
<div class="card overflow-hidden">
    <div class="data-table-container">
        <table>
            <thead>
                <tr>
                    <th>Date & Time</th>
                    <th>Event / Service</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $record)
                <tr>
                    <td>
                        <div class="font-medium text-cream">{{ $record->Timestamp->format('M d, Y') }}</div>
                        <div class="text-xs text-gold-muted mt-0.5">{{ $record->Timestamp->format('g:i A') }}</div>
                    </td>
                    <td>
                        <div class="font-medium {{ $record->event ? 'text-gold-mid' : 'text-cream' }}">
                            {{ $record->event ? $record->event->Title : 'Regular Sunday Service' }}
                        </div>
                        @if($record->event && $record->event->Location)
                            <div class="text-xs text-gold-muted mt-0.5 flex items-center gap-1.5">
                                <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2"/></svg>
                                {{ $record->event->Location }}
                            </div>
                        @endif
                    </td>
                    <td>
                        @if($record->Status === 'Present')
                            <span class="badge badge-green">Present</span>
                        @elseif($record->Status === 'Absent')
                            <span class="badge badge-red">Absent</span>
                        @else
                            <span class="badge badge-amber">{{ $record->Status }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h4>No Attendance Records</h4>
                            <p>Weekly logs will appear here after each service or event attendance.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($attendances->hasPages())
<div class="flex justify-center mt-6">
    {{ $attendances->links() }}
</div>
@endif
@endsection
