@extends('admin.layout.app')
@section('title', 'Edit Family — Grace Church CMS')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.families.index') }}" class="btn btn-ghost" style="padding:0.4rem 0.75rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
    </a>
    <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Edit Family</h1>
</div>

<div class="card p-6 max-w-xl">
    @if($errors->any())
        <div class="alert-error mb-4">
            @foreach($errors->all() as $error)<p class="text-sm">{{ $error }}</p>@endforeach
        </div>
    @endif
    <form method="POST" action="{{ route('admin.families.update', $family) }}">
        @csrf @method('PATCH')
        <div class="flex flex-col gap-4">
            <div>
                <label class="form-label">Family Name <span style="color:var(--red)">*</span></label>
                <input type="text" name="FamilyName" value="{{ old('FamilyName', $family->FamilyName) }}" class="form-input" required>
            </div>
            <div>
                <label class="form-label">Head of Family (Member)</label>
                <select name="MemberID" class="form-input">
                    <option value="">— None —</option>
                    @foreach($members as $member)
                        <option value="{{ $member->MemberID }}" {{ old('MemberID', $family->MemberID) == $member->MemberID ? 'selected' : '' }}>
                            {{ $member->FirstName }} {{ $member->LastName }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Home Address</label>
                <input type="text" name="HomeAddress" value="{{ old('HomeAddress', $family->HomeAddress) }}" class="form-input">
            </div>
            <div>
                <label class="form-label">Phone Number</label>
                <input type="text" name="PhoneNumber" value="{{ old('PhoneNumber', $family->PhoneNumber) }}" class="form-input">
            </div>
        </div>
        <div class="flex gap-3 mt-6">
            <button type="submit" class="btn btn-gold">Update Family</button>
            <a href="{{ route('admin.families.index') }}" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection
