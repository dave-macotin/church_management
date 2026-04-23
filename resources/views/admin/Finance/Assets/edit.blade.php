@extends('admin.layout.app')

@section('title', 'Edit Asset')

@section('content')

<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.assets.index') }}" class="btn btn-ghost" style="padding:0.4rem 0.8rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        Back
    </a>
    <div>
        <h1 class="font-cinzel text-xl font-semibold" style="color:var(--gold)">Edit Asset</h1>
        <p class="text-sm" style="color:var(--text-muted)">Update asset #{{ $asset->AssetID }}</p>
    </div>
</div>

<div class="card p-6" style="max-width:520px">
    <form action="{{ route('admin.assets.update', $asset) }}" method="POST">
        @csrf @method('PATCH')

        <div class="mb-4">
            <label class="form-label">Item Name *</label>
            <input type="text" name="ItemName" class="form-input"
                   value="{{ old('ItemName', $asset->ItemName) }}" required>
            @error('ItemName')
                <p class="text-xs mt-1" style="color:var(--red)">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label">Serial Number</label>
            <input type="text" name="SerialNumber" class="form-input"
                   value="{{ old('SerialNumber', $asset->SerialNumber) }}">
            @error('SerialNumber')
                <p class="text-xs mt-1" style="color:var(--red)">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label">Purchase Date</label>
            <input type="date" name="PurchaseDate" class="form-input"
                   value="{{ old('PurchaseDate', optional($asset->PurchaseDate)->format('Y-m-d')) }}">
            @error('PurchaseDate')
                <p class="text-xs mt-1" style="color:var(--red)">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="form-label">Value</label>
            <div class="flex items-center gap-2">
                <span style="color:var(--text-muted);font-size:0.9rem">₱</span>
                <input type="number" step="0.01" min="0" name="Value" class="form-input"
                       value="{{ old('Value', $asset->Value) }}">
            </div>
            @error('Value')
                <p class="text-xs mt-1" style="color:var(--red)">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn btn-gold">Update Asset</button>
            <a href="{{ route('admin.assets.index') }}" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>

@endsection
