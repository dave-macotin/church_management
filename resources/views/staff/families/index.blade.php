@extends('staff.layout.app')
@section('title', 'Families — Grace Church Staff')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Families</h1>
        <p class="text-sm mt-1" style="color:var(--text-muted)">{{ $families->total() }} families registered</p>
    </div>
    <a href="{{ route('staff.families.create') }}" class="btn btn-gold">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Add Family
    </a>
</div>

<form method="GET" class="flex gap-3 mb-5">
    <div class="search-wrap flex-1">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by family name, address…" class="form-input">
    </div>
    <button type="submit" class="btn btn-ghost">Filter</button>
    @if(request('search'))
        <a href="{{ route('staff.families.index') }}" class="btn btn-ghost">Clear</a>
    @endif
</form>

<div class="card overflow-hidden">
    <table class="w-full text-left">
        <thead>
            <tr style="background:var(--bg-panel); color:var(--gold-mid); font-size:11px; text-transform:uppercase;">
                <th class="p-4">Family Name</th>
                <th class="p-4">Head of Family</th>
                <th class="p-4">Address</th>
                <th class="p-4">Phone</th>
                <th class="p-4">Members</th>
                <th class="p-4"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
        @forelse($families as $family)
            <tr>
                <td class="p-4 font-semibold">{{ $family->FamilyName }}</td>
                <td class="p-4">{{ $family->headMember ? $family->headMember->FirstName . ' ' . $family->headMember->LastName : '—' }}</td>
                <td class="p-4 text-sm" style="color:var(--text-muted)">{{ $family->HomeAddress ?? '—' }}</td>
                <td class="p-4 text-sm" style="color:var(--text-muted)">{{ $family->PhoneNumber ?? '—' }}</td>
                <td class="p-4">
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase" style="background:var(--bg-hover); color:var(--gold-muted);">{{ $family->members->count() }} Members</span>
                </td>
                <td class="p-4">
                    <div class="flex items-center gap-2 justify-end">
                        <a href="{{ route('staff.families.show', $family) }}" class="btn btn-ghost" style="padding:0.35rem 0.7rem;font-size:0.8rem">View</a>
                        <a href="{{ route('staff.families.edit', $family) }}" class="btn btn-ghost" style="padding:0.35rem 0.7rem;font-size:0.8rem">Edit</a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center py-12" style="color:var(--text-muted)">No families found</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="flex justify-end mt-4 pagination">{{ $families->links() }}</div>
@endsection
