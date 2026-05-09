@extends('staff.layout.app')
@section('title', 'Members — Grace Church Staff')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Members</h1>
        <p class="text-sm mt-1" style="color:var(--text-muted)">{{ $members->total() }} registered members</p>
    </div>
    <a href="{{ route('staff.members.create') }}" class="btn btn-gold">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Add Member
    </a>
</div>

{{-- Filters --}}
<form method="GET" class="flex gap-3 mb-5">
    <div class="search-wrap flex-1">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, phone…" class="form-input">
    </div>
    <select name="status" class="form-input" style="width:160px">
        <option value="">All Statuses</option>
        <option value="Active"   {{ request('status') === 'Active'   ? 'selected' : '' }}>Active</option>
        <option value="Inactive" {{ request('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
        <option value="Pending"  {{ request('status') === 'Pending'  ? 'selected' : '' }}>Pending</option>
    </select>
    <button type="submit" class="btn btn-ghost">Filter</button>
    @if(request('search') || request('status'))
        <a href="{{ route('staff.members.index') }}" class="btn btn-ghost">Clear</a>
    @endif
</form>

<div class="card overflow-hidden">
    <div class="data-table-container">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Family</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($members as $member)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="user-avatar" 
                                 style="{{ $member->profile_picture ? 'background-image:url('.asset('storage/'.$member->profile_picture).'); color:transparent;' : 'background:var(--bg-hover);color:var(--gold-mid);' }}">
                                @if(!$member->profile_picture)
                                    {{ strtoupper(substr($member->FirstName, 0, 1) . substr($member->LastName, 0, 1)) }}
                                @endif
                            </div>
                            <div>
                                <div class="font-medium">{{ $member->FirstName }} {{ $member->LastName }}</div>
                                @if($member->role)
                                    <div class="text-xs" style="color:var(--gold-muted)">{{ $member->role->RoleName }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td style="color:var(--gold-muted)">{{ $member->Email ?? '—' }}</td>
                    <td style="color:var(--gold-muted)">{{ $member->PhoneNumber ?? '—' }}</td>
                    <td>{{ $member->family?->FamilyName ?? '—' }}</td>
                    <td>
                        @if($member->Status === 'Active')
                            <span class="badge badge-green">Active</span>
                        @elseif($member->Status === 'Inactive')
                            <span class="badge badge-red">Inactive</span>
                        @else
                            <span class="badge badge-amber">Pending</span>
                        @endif
                    </td>
                    <td style="color:var(--gold-muted)">{{ $member->created_at?->format('M d, Y') }}</td>
                    <td>
                        <div class="flex items-center gap-2 justify-end">
                            <a href="{{ route('staff.members.show', $member) }}" class="btn btn-ghost btn-sm">View</a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                            </svg>
                            <h4>No Members Found</h4>
                            <p>Try adjusting your search or filters to find what you're looking for.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="flex justify-end mt-4 pagination">
    {{ $members->links() }}
</div>
@endsection
