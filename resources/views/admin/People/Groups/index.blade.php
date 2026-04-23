@extends('admin.Layout.app')
@section('title', 'Groups — Grace Church CMS')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Groups</h1>
        <p class="text-sm mt-1" style="color:var(--text-muted)">{{ $groups->total() }} groups</p>
    </div>
    <a href="{{ route('admin.groups.create') }}" class="btn btn-gold">
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
        <a href="{{ route('admin.groups.index') }}" class="btn btn-ghost">Clear</a>
    @endif
</form>

<div class="card overflow-hidden">
    <div class="data-table-container">
        <table>
            <thead>
                <tr>
                    <th>Group Name</th>
                    <th>Description</th>
                    <th>Linked Event</th>
                    <th>Created</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($groups as $group)
                <tr>
                    <td class="font-medium text-gold-mid">{{ $group->GroupName }}</td>
                    <td style="color:var(--gold-muted);max-width:280px">
                        {{ $group->Description ? Str::limit($group->Description, 80) : '—' }}
                    </td>
                    <td>
                        @if($group->event)
                            <span class="badge badge-blue">{{ $group->event->Title }}</span>
                        @else
                            <span class="text-xs text-muted">—</span>
                        @endif
                    </td>
                    <td style="color:var(--gold-muted)">{{ $group->created_at?->format('M d, Y') }}</td>
                    <td>
                        <div class="flex items-center gap-2 justify-end">
                            <a href="{{ route('admin.groups.edit', $group) }}" class="btn btn-ghost btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.groups.destroy', $group) }}"
                                  onsubmit="return confirm('Delete {{ $group->GroupName }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.998 5.998 0 00-1.261-3.606M12 18a4.5 4.5 0 01-4.5-4.5V13.5a4.5 4.5 0 119 0v.003c0 .356-.041.703-.119 1.034m-3.381 3.463L12 18m0 0l-3 3"/>
                            </svg>
                            <h4>No Groups Found</h4>
                            <p>You haven't created any groups yet.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="flex justify-end mt-4 pagination">{{ $groups->links() }}</div>
@endsection
