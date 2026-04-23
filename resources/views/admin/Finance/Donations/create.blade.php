@extends('admin.layout.app')

@section('title', 'Record Donation')

@section('content')

<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.donations.index') }}" class="btn btn-ghost" style="padding:0.4rem 0.8rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        Back
    </a>
    <div>
        <h1 class="font-cinzel text-xl font-semibold" style="color:var(--gold)">Record Donation</h1>
        <p class="text-sm" style="color:var(--text-muted)">Add a new donation and link it to an existing member</p>
    </div>
</div>

<div class="card p-6" style="max-width:560px">
    <form action="{{ route('admin.donations.store') }}" method="POST">
        @csrf

        {{-- Donor (Member) --}}
        <div class="mb-4">
            <label class="form-label">Donor (Member) *</label>
            <select name="MemberID" class="form-input @error('MemberID') border-red-500 @enderror" required>
                <option value="">— Select a member —</option>
                @foreach($members as $member)
                    <option value="{{ $member->MemberID }}"
                        {{ old('MemberID') == $member->MemberID ? 'selected' : '' }}>
                        {{ $member->LastName }}, {{ $member->FirstName }}
                    </option>
                @endforeach
            </select>
            @error('MemberID')
                <p class="text-xs mt-1" style="color:var(--red)">{{ $message }}</p>
            @enderror
            @if($members->isEmpty())
                <p class="text-xs mt-1" style="color:var(--red)">
                    No members found. Please add members first before recording a donation.
                </p>
            @endif
        </div>

        {{-- Amount --}}
        <div class="mb-4">
            <label class="form-label">Amount *</label>
            <div class="flex items-center gap-2">
                <span style="color:var(--text-muted);font-size:0.9rem">₱</span>
                <input type="number" step="0.01" min="1" name="Amount"
                       class="form-input @error('Amount') border-red-500 @enderror"
                       value="{{ old('Amount') }}" required placeholder="0.00">
            </div>
            @error('Amount')
                <p class="text-xs mt-1" style="color:var(--red)">{{ $message }}</p>
            @enderror
        </div>

        {{-- Date --}}
        <div class="mb-4">
            <label class="form-label">Date *</label>
            <input type="date" name="Date"
                   class="form-input @error('Date') border-red-500 @enderror"
                   value="{{ old('Date', date('Y-m-d')) }}" required>
            @error('Date')
                <p class="text-xs mt-1" style="color:var(--red)">{{ $message }}</p>
            @enderror
        </div>

        {{-- Fund Category --}}
        <div class="mb-6">
            <label class="form-label">Fund Category *</label>
            <select name="FundCategory" class="form-input @error('FundCategory') border-red-500 @enderror" required>
                <option value="">— Select a category —</option>
                @foreach(['Tithe','Offering','Mission','Building Fund','Special','Other'] as $cat)
                    <option value="{{ $cat }}" {{ old('FundCategory') === $cat ? 'selected' : '' }}>
                        {{ $cat }}
                    </option>
                @endforeach
            </select>
            @error('FundCategory')
                <p class="text-xs mt-1" style="color:var(--red)">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn btn-gold">Save Donation</button>
            <a href="{{ route('admin.donations.index') }}" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>

@endsection
