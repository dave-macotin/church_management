@extends('admin.layout.app')

@section('title', 'Add Asset')

@section('content')

<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.assets.index') }}" class="btn btn-ghost" style="padding:0.4rem 0.8rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        Back
    </a>
    <div>
        <h1 class="font-cinzel text-xl font-semibold" style="color:var(--gold-mid)">Add Asset</h1>
        <p class="text-sm" style="color:var(--gold-muted)">Register a new church asset</p>
    </div>
</div>

<div class="card p-6" style="max-width:560px">
    <form action="{{ route('admin.assets.store') }}" method="POST">
        @csrf

        {{-- Item Name --}}
        <div class="mb-4">
            <label class="form-label" style="font-size:11px; color:var(--gold-muted); text-transform:uppercase; margin-bottom:8px; display:block;">Item Name *</label>
            <input type="text" name="ItemName" class="form-input @error('ItemName') border-red-500 @enderror"
                   value="{{ old('ItemName') }}" required placeholder="e.g. Projector, Sound System…">
            @error('ItemName') 
                <p class="text-xs mt-1" style="color:var(--red)">{{ $message }}</p>
            @enderror
        </div>

        {{-- Serial Number --}}
        <div class="mb-4">
            <label class="form-label" style="font-size:11px; color:var(--gold-muted); text-transform:uppercase; margin-bottom:8px; display:block;">Serial Number</label>
            <input type="text" name="SerialNumber" class="form-input @error('SerialNumber') border-red-500 @enderror"
                   value="{{ old('SerialNumber') }}" placeholder="Optional serial / tag number">
            @error('SerialNumber')
                <p class="text-xs mt-1" style="color:var(--red)">{{ $message }}</p>
            @enderror
        </div>

        {{-- Purchase Date --}}
        <div class="mb-4">
            <label class="form-label" style="font-size:11px; color:var(--gold-muted); text-transform:uppercase; margin-bottom:8px; display:block;">Purchase Date</label>
            <input type="date" name="PurchaseDate" class="form-input @error('PurchaseDate') border-red-500 @enderror"
                   value="{{ old('PurchaseDate') }}">
            @error('PurchaseDate')
                <p class="text-xs mt-1" style="color:var(--red)">{{ $message }}</p>
            @enderror
        </div>

        {{-- Value --}}
        <div class="mb-6">
            <label class="form-label" style="font-size:11px; color:var(--gold-muted); text-transform:uppercase; margin-bottom:8px; display:block;">Value</label>
            <div class="flex items-center gap-2">
                <span class="text-sm" style="color:var(--gold-muted);">₱</span>
                <input type="number" step="0.01" name="Value"
                       class="form-input @error('Value') border-red-500 @enderror"
                       value="{{ old('Value') }}" placeholder="0.00" style="width:100%;">
            </div>
            @error('Value')
                <p class="text-xs mt-1" style="color:var(--red)">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn btn-gold">Save Asset</button>
            <a href="{{ route('admin.assets.index') }}" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection
