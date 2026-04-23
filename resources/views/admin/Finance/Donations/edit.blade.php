@extends('admin.layout.app')

@section('title', 'Edit Donation')

@section('content')

<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.donations.index') }}" class="btn btn-ghost" style="padding:0.4rem 0.8rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        Back
    </a>
    <div>
        <h1 class="font-cinzel text-xl font-semibold" style="color:var(--gold)">Edit Donation</h1>
        <p class="text-sm" style="color:var(--text-muted)">Update donation #{{ $donation->DonationID }}</p>
    </div>
</div>

<div class="card p-6" style="max-width:520px">
    <form action="{{ route('admin.donations.update', $donation) }}" method="POST">
        @csrf @method('PATCH')

        <div class="mb-4">
            <label class="form-label">Amount *</label>
            <div class="flex items-center gap-2">
                <span style="color:var(--text-muted);font-size:0.9rem">₱</span>
                <input type="number" step="0.01" min="0" name="Amount"
                       class="form-input"
                       value="{{ old('Amount', $donation->Amount) }}" required>
            </div>
            @error('Amount')
                <p class="text-xs mt-1" style="color:var(--red)">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label">Date *</label>
            <input type="date" name="Date" class="form-input"
                   value="{{ old('Date', optional($donation->Date)->format('Y-m-d')) }}" required>
            @error('Date')
                <p class="text-xs mt-1" style="color:var(--red)">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="form-label">Fund Category</label>
            <input type="text" name="FundCategory" class="form-input"
                   value="{{ old('FundCategory', $donation->FundCategory) }}"
                   placeholder="e.g. Tithes, Building Fund…">
            @error('FundCategory')
                <p class="text-xs mt-1" style="color:var(--red)">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn btn-gold">Update Donation</button>
            <a href="{{ route('admin.donations.index') }}" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>

@endsection
