@extends('admin.Layout.app')
@section('title', 'Sermons — Grace Church CMS')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
    <div>
        <h1 class="font-cinzel text-2xl" style="color:var(--gold-mid)">Sermon Management</h1>
        <p class="text-sm mt-1" style="color:var(--gold-muted)">{{ $sermons->total() }} recorded messages in the library</p>
    </div>
    <div class="flex gap-3">
        <form method="GET" action="{{ route('admin.sermons.index') }}" class="search-wrap" style="width:300px">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
            <input type="text" name="search" class="form-input" placeholder="Search sermons..." value="{{ request('search') }}">
        </form>
        <button onclick="document.getElementById('addSermonForm').scrollIntoView({behavior:'smooth'})" class="btn btn-gold">
            Add New Message
        </button>
    </div>
</div>

{{-- Add Sermon Form --}}
<div id="addSermonForm" class="card p-6 max-w-2xl mb-12" style="border: 1px solid var(--gold-bright); background: linear-gradient(135deg, var(--bg-card) 0%, #2a1a0a 100%);">
    <h3 class="font-cinzel text-lg mb-6 flex items-center gap-2" style="color:var(--gold-mid)">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
        New Sermon Entry
    </h3>
    <form method="POST" action="{{ route('admin.sermons.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="info-label" style="font-size:11px; color:var(--gold-muted); text-transform:uppercase; margin-bottom:6px; display:block;">Title <span style="color:var(--red)">*</span></label>
                <input type="text" name="title" class="form-input" placeholder="e.g. Walking in the Light" required>
            </div>
            <div>
                <label class="info-label" style="font-size:11px; color:var(--gold-muted); text-transform:uppercase; margin-bottom:6px; display:block;">Preacher <span style="color:var(--red)">*</span></label>
                <input type="text" name="preacher" class="form-input" placeholder="e.g. Pastor John Doe" required>
            </div>
            <div>
                <label class="info-label" style="font-size:11px; color:var(--gold-muted); text-transform:uppercase; margin-bottom:6px; display:block;">Date Preached <span style="color:var(--red)">*</span></label>
                <input type="date" name="preached_at" value="{{ date('Y-m-d') }}" class="form-input" required>
            </div>
            <div class="md:col-span-2">
                <label class="info-label" style="font-size:11px; color:var(--gold-muted); text-transform:uppercase; margin-bottom:6px; display:block;">Video URL (YouTube/Vimeo)</label>
                <input type="url" name="video_url" placeholder="https://youtube.com/watch?v=..." class="form-input">
            </div>
            <div>
                <label class="info-label" style="font-size:11px; color:var(--gold-muted); text-transform:uppercase; margin-bottom:6px; display:block;">Sermon Series</label>
                <input type="text" name="series" class="form-input" placeholder="e.g. The Gospel of John">
            </div>
            <div>
                <label class="info-label" style="font-size:11px; color:var(--gold-muted); text-transform:uppercase; margin-bottom:6px; display:block;">Custom Thumbnail (Optional)</label>
                <input type="file" name="thumbnail_url" class="form-input" accept="image/*">
                <small class="text-[10px] opacity-50 mt-1 block">Fallbacks to YouTube thumbnail if empty</small>
            </div>
            <div class="md:col-span-2">
                <label class="info-label" style="font-size:11px; color:var(--gold-muted); text-transform:uppercase; margin-bottom:6px; display:block;">Description / Summary</label>
                <textarea name="description" class="form-input" rows="3" placeholder="Brief overview of the message..."></textarea>
            </div>
        </div>
        <div class="mt-8 flex justify-end">
            <button type="submit" class="btn btn-gold px-8 py-3">Add to Library</button>
        </div>
    </form>
</div>

<h2 class="font-cinzel text-xl mb-6 flex items-center gap-2" style="color:var(--gold-mid)">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
    Library Contents
</h2>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($sermons as $sermon)
        <div class="card overflow-hidden flex flex-col group transition-all duration-300 hover:-translate-y-1" style="{{ !$sermon->is_approved ? 'border-color: var(--accent);' : '' }}">
            <div class="aspect-video bg-black/40 relative">
                @php
                    $thumb = $sermon->thumbnail_url;
                    if ($thumb && !str_starts_with($thumb, 'http')) {
                        $thumb = asset('storage/' . $thumb);
                    } elseif (!$thumb && $sermon->video_url) {
                        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $sermon->video_url, $match);
                        $youtube_id = $match[1] ?? null;
                        $thumb = $youtube_id ? "https://img.youtube.com/vi/{$youtube_id}/mqdefault.jpg" : asset('images/hero.png');
                    } else {
                        $thumb = asset('images/hero.png');
                    }
                @endphp
                <img src="{{ $thumb }}" class="w-full h-full object-cover {{ !$sermon->is_approved ? 'opacity-40 grayscale' : 'opacity-80 group-hover:opacity-100' }} transition-all" alt="Sermon">
                
                @if(!$sermon->is_approved)
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="badge badge-amber px-4 py-2 text-xs font-bold uppercase shadow-2xl">Pending Approval</span>
                    </div>
                @endif

                <div class="absolute bottom-2 right-2 badge badge-muted text-[10px]" style="background: rgba(0,0,0,0.6);">{{ $sermon->preached_at->format('M d, Y') }}</div>
            </div>

            <div class="p-5 flex-1 flex flex-col">
                <div class="text-[10px] uppercase tracking-widest font-bold mb-1" style="color:var(--gold-muted)">{{ $sermon->series ?? 'Standalone Message' }}</div>
                <h3 class="font-cinzel text-lg mb-2" style="color:var(--gold-mid)">{{ $sermon->title }}</h3>
                <p class="text-xs line-clamp-2 mb-4" style="color:var(--cream); opacity: 0.7;">{{ $sermon->description }}</p>
                
                <div class="mt-auto pt-4 border-t border-white/5 flex flex-col gap-3">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-semibold italic" style="color:var(--gold-muted)">Pr. {{ $sermon->preacher }}</span>
                        <div class="flex gap-2">
                             @if(!$sermon->is_approved)
                                <form method="POST" action="{{ route('admin.sermons.approve', $sermon->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-active flex items-center gap-2 text-[10px] py-1.5 px-3 h-auto" style="background:rgba(34,197,94,0.1); color:#4ade80; border-color:rgba(34,197,94,0.2);">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                                        Approve
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('sermons.show', $sermon->id) }}" class="btn btn-gold flex items-center gap-2 text-[10px] py-1.5 px-3 h-auto">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Preview
                            </a>
                             @if(auth()->user()->role === 'admin')
                                <form method="POST" action="{{ route('admin.sermons.destroy', $sermon->id) }}" onsubmit="return confirm('Delete this sermon permanently?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-ghost flex items-center gap-2 text-[10px] py-1.5 px-3 h-auto" style="color:#f87171; border-color:rgba(248,113,113,0.2);">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-[10px] opacity-40">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Submitted by: {{ $sermon->submittedBy->name ?? 'System' }}
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full py-20 text-center card bg-panel/30 border-dashed">
            <div class="text-5xl mb-4 opacity-20">📖</div>
            <p style="color:var(--gold-muted)">The sermon library is currently empty.</p>
        </div>
    @endforelse
</div>

<div class="mt-12 flex justify-end">
    {{ $sermons->links() }}
</div>
@endsection
