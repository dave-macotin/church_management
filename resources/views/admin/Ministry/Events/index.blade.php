@extends('admin.layout.app')
@section('title', 'Events — Grace Church CMS')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
    <div>
        <h1 class="font-cinzel text-2xl" style="color:var(--gold-mid)">Sacred Events</h1>
        <p class="text-sm mt-1" style="color:var(--gold-muted)">{{ $events->total() }} events registered</p>
    </div>
    <a href="{{ route('admin.events.create') }}" class="btn btn-gold">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Add Event
    </a>
</div>

<form method="GET" class="flex flex-col md:flex-row gap-4 mb-8">
    <div class="relative flex-1">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gold-muted/50" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
        </svg>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title, location…" class="form-input !pl-10">
    </div>
    <div class="flex gap-2">
        <select name="filter" class="form-input" style="width:160px">
            <option value="">All Events</option>
            <option value="upcoming" {{ request('filter') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
            <option value="past"     {{ request('filter') === 'past'     ? 'selected' : '' }}>Past</option>
        </select>
        <button type="submit" class="btn btn-gold">Filter</button>
        @if(request('search') || request('filter'))
            <a href="{{ route('admin.events.index') }}" class="btn btn-ghost">Clear</a>
        @endif
    </div>
</form>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($events as $event)
        <div class="card overflow-hidden flex flex-col group transition-all duration-300 hover:-translate-y-1" style="{{ !$event->is_approved ? 'border-color: var(--accent);' : '' }}">
            <div class="aspect-video bg-black/40 relative">
                @if($event->image)
                    <img src="{{ asset('storage/' . $event->image) }}" class="w-full h-full object-cover {{ !$event->is_approved ? 'opacity-40 grayscale' : 'opacity-80 group-hover:opacity-100' }} transition-all" alt="Event Image">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center bg-panel/50 text-gold-muted/30">
                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                        <span class="text-[10px] uppercase tracking-widest font-bold">No Preview Image</span>
                    </div>
                @endif
                
                @if(!$event->is_approved)
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="badge badge-amber px-4 py-2 text-xs font-bold uppercase shadow-2xl">Pending Approval</span>
                    </div>
                @endif

                <div class="absolute bottom-2 right-2 badge badge-muted text-[10px]" style="background: rgba(0,0,0,0.6);">
                    {{ $event->StartDateTime?->format('F d, Y') }}
                </div>
            </div>

            <div class="p-5 flex-1 flex flex-col">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-cinzel text-lg" style="color:var(--gold-mid)">{{ $event->Title }}</h3>
                    @if($event->is_approved && $event->StartDateTime?->isFuture())
                         <span class="badge badge-green text-[10px]">Upcoming</span>
                    @elseif($event->is_approved)
                         <span class="badge badge-muted text-[10px]">Past</span>
                    @endif
                </div>
                
                <div class="space-y-2 mb-4">
                    <div class="flex items-center gap-2 text-xs" style="color:var(--gold-muted)">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        {{ $event->Location ?? 'Virtual/Sanctuary' }}
                    </div>
                    <div class="flex items-center gap-2 text-xs" style="color:var(--gold-muted)">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 6v6l4 2"/></svg>
                        {{ $event->StartDateTime?->format('g:i A') }} — {{ $event->EndDateTime?->format('g:i A') }}
                    </div>
                </div>

                <div class="mt-auto pt-4 border-t border-white/5 flex flex-col gap-3">
                    <div class="flex justify-between items-center">
                        <div class="flex gap-2">
                             @if(auth()->user()->role === 'admin' && !$event->is_approved)
                                <form method="POST" action="{{ route('admin.events.approve', $event) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-active flex items-center gap-2 text-[10px] py-1.5 px-3 h-auto" style="background:rgba(34,197,94,0.1); color:#4ade80; border-color:rgba(34,197,94,0.2);">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                                        Approve
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-gold flex items-center gap-2 text-[10px] py-1.5 px-3 h-auto">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                             @if(auth()->user()->role === 'admin')
                                <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Delete this event permanently?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-ghost flex items-center gap-2 text-[10px] py-1.5 px-3 h-auto" style="color:#f87171; border-color:rgba(248,113,113,0.2);">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 text-[10px] opacity-40">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            {{ $event->submittedBy->name ?? 'System' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full py-20 text-center card bg-panel/30 border-dashed">
            <div class="text-5xl mb-4 opacity-20">📅</div>
            <p style="color:var(--gold-muted)">No religious events match your criteria.</p>
        </div>
    @endforelse
</div>

<div class="mt-12 flex justify-end">
    {{ $events->appends(request()->query())->links() }}
</div>
@endsection
