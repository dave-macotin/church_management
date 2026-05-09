@extends('staff.layout.app')
@section('title', 'Groups — Grace Church Staff')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Groups</h1>
        <p class="text-sm mt-1" style="color:var(--text-muted)">{{ $groups->total() }} groups registered</p>
    </div>
    <a href="{{ route('staff.groups.create') }}" class="btn btn-gold">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Add Group
    </a>
</div>

<form method="GET" class="flex gap-3 mb-5">
    <div class="search-wrap flex-1">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search groups…" class="form-input">
    </div>
    <button type="submit" class="btn btn-ghost">Filter</button>
    @if(request('search'))
        <a href="{{ route('staff.groups.index') }}" class="btn btn-ghost">Clear</a>
    @endif
</form>

<div class="card overflow-hidden">
    <table class="w-full text-left">
        <thead>
            <tr style="background:var(--bg-panel); color:var(--gold-mid); font-size:11px; text-transform:uppercase;">
                <th class="p-4">Group Name</th>
                <th class="p-4">Description</th>
                <th class="p-4">Linked Event</th>
                <th class="p-4">Created</th>
                <th class="p-4"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
        @forelse($groups as $group)
            <tr>
                <td class="p-4 font-semibold">{{ $group->GroupName }}</td>
                <td class="p-4 text-sm" style="color:var(--text-muted); max-width:280px">
                    {{ $group->Description ? Str::limit($group->Description, 80) : '—' }}
                </td>
                <td class="p-4 text-sm">{{ $group->event?->Title ?? '—' }}</td>
                <td class="p-4 text-sm" style="color:var(--text-muted)">{{ $group->created_at?->format('M d, Y') }}</td>
                <td class="p-4">
                    <div class="flex items-center gap-2 justify-end">
                        <a href="{{ route('staff.groups.show', $group) }}" class="btn btn-ghost" style="padding:0.35rem 0.7rem;font-size:0.8rem">View</a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center py-12" style="color:var(--text-muted)">No groups found</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="flex justify-end mt-4 pagination">{{ $groups->links() }}</div>
@endsection
