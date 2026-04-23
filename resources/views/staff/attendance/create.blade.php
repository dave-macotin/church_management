@extends('staff.layout.app')
@section('title', 'Log Attendance — Grace Church Staff')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('staff.attendance.index') }}" class="btn btn-ghost" style="padding:0.4rem 0.75rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
    </a>
    <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Log Attendance</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">

    {{-- Single record --}}
    <div class="card p-6">
        <h2 class="font-cinzel text-lg mb-4" style="color:var(--gold-mid)">Single Record</h2>
        @if($errors->any())
            <div class="mb-4 p-3 rounded bg-red-500/10 border border-red-500/20 text-red-500 text-sm">
                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
        @endif
        <form method="POST" action="{{ route('staff.attendance.store') }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Member *</label>
                    <select name="MemberID" class="form-input mt-1" required>
                        <option value="">Select member…</option>
                        @foreach($members as $member)
                            <option value="{{ $member->MemberID }}" {{ old('MemberID') == $member->MemberID ? 'selected' : '' }}>
                                {{ $member->FirstName }} {{ $member->LastName }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Status *</label>
                    <select name="Status" class="form-input mt-1" required>
                        <option value="Present" {{ old('Status','Present') === 'Present' ? 'selected' : '' }}>Present</option>
                        <option value="Absent"  {{ old('Status') === 'Absent'  ? 'selected' : '' }}>Absent</option>
                        <option value="Excused" {{ old('Status') === 'Excused' ? 'selected' : '' }}>Excused</option>
                    </select>
                </div>
                <div>
                    <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Date & Time *</label>
                    <input type="datetime-local" name="Timestamp"
                           value="{{ old('Timestamp', now()->format('Y-m-d\TH:i')) }}"
                           class="form-input mt-1" required>
                </div>
            </div>
            <div class="flex gap-3 mt-8">
                <button type="submit" class="btn btn-gold">Save Entry</button>
                <a href="{{ route('staff.attendance.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>

    {{-- Bulk record --}}
    <div class="card p-6">
        <h2 class="font-cinzel text-lg mb-4" style="color:var(--gold-mid)">Bulk Entry Sheet</h2>
        <form method="POST" action="{{ route('staff.attendance.bulk') }}">
            @csrf
            <div class="mb-6">
                <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Service / Session Date *</label>
                <input type="datetime-local" name="Timestamp"
                       value="{{ now()->format('Y-m-d\TH:i') }}"
                       class="form-input mt-1" required>
            </div>
            <div class="overflow-y-auto border border-white/5 rounded-lg mb-6" style="max-height:400px;">
                <table class="w-full text-left text-sm">
                    <thead class="sticky top-0 bg-panel text-[10px] uppercase font-bold tracking-widest" style="color:var(--gold-muted); z-index:10;">
                        <tr>
                            <th class="p-3">Member</th>
                            <th class="p-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                    @foreach($members as $i => $member)
                        <tr>
                            <td class="p-3">
                                <input type="hidden" name="records[{{ $i }}][MemberID]" value="{{ $member->MemberID }}">
                                <span class="font-medium">{{ $member->FirstName }} {{ $member->LastName }}</span>
                            </td>
                            <td class="p-3">
                                <select name="records[{{ $i }}][Status]" class="bg-black/20 border border-white/10 rounded px-2 py-1 text-xs outline-none focus:border-gold/50">
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
            <button type="submit" class="btn btn-gold w-full py-3">
                Save All ({{ $members->count() }} members)
            </button>
        </form>
    </div>

</div>
@endsection
