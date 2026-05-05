@extends('admin.layout.app')
@section('title', 'Log Attendance — Grace Church CMS')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.attendance.index') }}" class="btn btn-ghost" style="padding:0.4rem 0.75rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
    </a>
    <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Log Attendance</h1>
</div>

<div class="flex gap-6 items-start">

    {{-- Single record --}}
    <div class="card p-6 flex-1">
        <h2 class="font-cinzel text-lg mb-4" style="color:var(--gold-light)">Single Record</h2>
        @if($errors->any())
            <div class="alert-error mb-4">
                @foreach($errors->all() as $error)<p class="text-sm">{{ $error }}</p>@endforeach
            </div>
        @endif
        <form method="POST" action="{{ route('admin.attendance.store') }}">
            @csrf
            <div class="flex flex-col gap-4">
                <div>
                    <label class="form-label">Member <span style="color:var(--red)">*</span></label>
                    <select name="MemberID" class="form-input" required>
                        <option value="">Select member…</option>
                        @foreach($members as $member)
                            <option value="{{ $member->MemberID }}" {{ old('MemberID') == $member->MemberID ? 'selected' : '' }}>
                                {{ $member->FirstName }} {{ $member->LastName }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Status <span style="color:var(--red)">*</span></label>
                    <select name="Status" class="form-input" required>
                        <option value="Present" {{ old('Status','Present') === 'Present' ? 'selected' : '' }}>Present</option>
                        <option value="Absent"  {{ old('Status') === 'Absent'  ? 'selected' : '' }}>Absent</option>
                        <option value="Excused" {{ old('Status') === 'Excused' ? 'selected' : '' }}>Excused</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Date & Time <span style="color:var(--red)">*</span></label>
                    <input type="datetime-local" name="Timestamp"
                           value="{{ old('Timestamp', now()->format('Y-m-d\TH:i')) }}"
                           class="form-input" required>
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="submit" class="btn btn-gold">Save</button>
                <a href="{{ route('admin.attendance.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>

    {{-- Bulk record --}}
    <div class="card p-6 flex-1">
        <h2 class="font-cinzel text-lg mb-4" style="color:var(--gold-light)">Bulk Sheet</h2>
        <form method="POST" action="{{ route('admin.attendance.bulk') }}">
            @csrf
            <div class="mb-4">
                <label class="form-label">Service / Session Date <span style="color:var(--red)">*</span></label>
                <input type="datetime-local" name="Timestamp"
                       value="{{ now()->format('Y-m-d\TH:i') }}"
                       class="form-input" required>
            </div>
            <div class="card overflow-hidden mb-4" style="max-height:380px;overflow-y:auto">
                <table>
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th style="text-align:center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($members as $i => $member)
                        <tr>
                            <td>
                                <input type="hidden" name="records[{{ $i }}][MemberID]" value="{{ $member->MemberID }}">
                                {{ $member->FirstName }} {{ $member->LastName }}
                            </td>
                            <td>
                                <select name="records[{{ $i }}][Status]" class="form-input" style="padding:0.3rem 0.5rem;font-size:0.8rem">
                                    <option value="Present">Present</option>
                                    <option value="Absent">Absent</option>
                                    <option value="Excused">Excused</option>
                                </select>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-gold w-full" style="justify-content:center">
                Save All ({{ $members->count() }} members)
            </button>
        </form>
    </div>

</div>
@endsection
