@extends('admin.layout.app')
@section('title', 'Edit Attendance — Grace Church CMS')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.attendance.index') }}" class="btn btn-ghost" style="padding:0.4rem 0.75rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
    </a>
    <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Edit Attendance</h1>
</div>

<div class="card p-6 max-w-md">
    @if($errors->any())
        <div class="alert-error mb-4">
            @foreach($errors->all() as $error)<p class="text-sm">{{ $error }}</p>@endforeach
        </div>
    @endif
    <form method="POST" action="{{ route('admin.attendance.update', $attendance) }}">
        @csrf @method('PATCH')
        <div class="flex flex-col gap-4">
            <div>
                <label class="form-label">Member <span style="color:var(--red)">*</span></label>
                <select name="MemberID" class="form-input" required>
                    <option value="">Select member…</option>
                    @foreach($members as $member)
                        <option value="{{ $member->MemberID }}"
                            {{ old('MemberID', $attendance->MemberID) == $member->MemberID ? 'selected' : '' }}>
                            {{ $member->FirstName }} {{ $member->LastName }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Status <span style="color:var(--red)">*</span></label>
                <select name="Status" class="form-input" required>
                    <option value="Present" {{ old('Status', $attendance->Status) === 'Present' ? 'selected' : '' }}>Present</option>
                    <option value="Absent"  {{ old('Status', $attendance->Status) === 'Absent'  ? 'selected' : '' }}>Absent</option>
                    <option value="Excused" {{ old('Status', $attendance->Status) === 'Excused' ? 'selected' : '' }}>Excused</option>
                </select>
            </div>
            <div>
                <label class="form-label">Date & Time <span style="color:var(--red)">*</span></label>
                <input type="datetime-local" name="Timestamp"
                       value="{{ old('Timestamp', $attendance->Timestamp?->format('Y-m-d\TH:i')) }}"
                       class="form-input" required>
            </div>
        </div>
        <div class="flex gap-3 mt-6">
            <button type="submit" class="btn btn-gold">Update</button>
            <a href="{{ route('admin.attendance.index') }}" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection
