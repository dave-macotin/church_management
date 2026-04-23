@extends('admin.layout.app')

@section('title', 'Assets')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-cinzel text-xl font-semibold" style="color:var(--gold)">Assets</h1>
        <p class="text-sm mt-0.5" style="color:var(--text-muted)">Church property and inventory</p>
    </div>
    <a href="{{ route('admin.assets.create') }}" class="btn btn-gold">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Add Asset
    </a>
</div>

{{-- Stat --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="card p-6 flex items-center gap-5 border-l-4 border-l-gold-bright">
        <div class="w-12 h-12 rounded-xl bg-gold-bright/10 flex items-center justify-center text-gold-bright">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:24px;height:24px"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
        </div>
        <div>
            <div class="text-[10px] font-bold text-gold-muted uppercase tracking-wider mb-1">Asset Valuation</div>
            <div class="font-cinzel text-2xl font-bold text-gold-bright">₱{{ number_format($totalValue, 2) }}</div>
        </div>
    </div>
</div>

<form method="GET" action="{{ route('admin.assets.index') }}" class="mb-6">
    <div class="search-wrap" style="max-width:400px">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
        <input type="text" name="search" class="form-input" placeholder="Search item name or serial…"
               value="{{ request('search') }}">
    </div>
</form>

<div class="card overflow-hidden">
    <div class="data-table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item Name</th>
                    <th>Serial Number</th>
                    <th>Purchase Date</th>
                    <th>Value</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($assets as $asset)
                    <tr>
                        <td style="color:var(--gold-muted)">#{{ $asset->AssetID }}</td>
                        <td><span class="text-cream font-medium">{{ $asset->ItemName }}</span></td>
                        <td style="color:var(--gold-muted)">{{ $asset->SerialNumber ?? '—' }}</td>
                        <td style="color:var(--gold-muted)">
                            {{ $asset->PurchaseDate ? $asset->PurchaseDate->format('M d, Y') : '—' }}
                        </td>
                        <td><span class="font-bold text-gold-bright">₱{{ number_format($asset->Value ?? 0, 2) }}</span></td>
                        <td>
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.assets.edit', $asset) }}" class="btn btn-ghost btn-sm">
                                    Edit
                                </a>
                                <form action="{{ route('admin.assets.destroy', $asset) }}"
                                      method="POST" onsubmit="return confirm('Delete this asset?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
                                </svg>
                                <h4>No Assets Found</h4>
                                <p>You haven't recorded any church inventory or property yet.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($assets->hasPages())
    <div class="flex gap-1 mt-4 pagination">
        {{ $assets->links() }}
    </div>
@endif

@endsection
