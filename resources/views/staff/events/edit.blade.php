@extends('staff.layout.app')
@section('title', 'Modify Event — Grace Church Staff')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('staff.events.index') }}" class="btn btn-ghost" style="padding:0.4rem 0.75rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
    </a>
    <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Modify Event</h1>
</div>

<div class="card p-6 max-w-xl">
    @if(!$event->is_approved)
    <div class="mb-6 p-4 bg-amber-500/10 border border-amber-500/20 rounded-lg">
        <p class="text-xs text-amber-500 font-bold uppercase tracking-wider flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            Modification Needs Review
        </p>
        <p class="text-xs mt-1 opacity-70">This event is currently awaiting approval. Any changes you make will be reviewed by an administrator.</p>
    </div>
    @endif

    @if($errors->any())
        <div class="alert-error mb-4">
            @foreach($errors->all() as $error)<p class="text-sm">{{ $error }}</p>@endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('staff.events.update', $event) }}" enctype="multipart/form-data">
        @csrf @method('PATCH')
        <div class="flex flex-col gap-4">
            <div>
                <label class="form-label text-[11px] uppercase tracking-wider text-gold-muted mb-2 block">Title <span style="color:var(--red)">*</span></label>
                <input type="text" name="Title" value="{{ old('Title', $event->Title) }}" class="form-input" required>
            </div>
            <div>
                <label class="form-label text-[11px] uppercase tracking-wider text-gold-muted mb-2 block">Location</label>
                <input type="text" name="Location" value="{{ old('Location', $event->Location) }}" class="form-input">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label text-[11px] uppercase tracking-wider text-gold-muted mb-2 block">Start Date & Time <span style="color:var(--red)">*</span></label>
                    <input type="datetime-local" name="StartDateTime" 
                           value="{{ old('StartDateTime', $event->StartDateTime?->format('Y-m-d\TH:i')) }}" 
                           class="form-input" required>
                </div>
                <div>
                    <label class="form-label text-[11px] uppercase tracking-wider text-gold-muted mb-2 block">End Date & Time</label>
                    <input type="datetime-local" name="EndDateTime" 
                           value="{{ old('EndDateTime', $event->EndDateTime?->format('Y-m-d\TH:i')) }}" 
                           class="form-input">
                </div>
            </div>
            <div>
                <label class="form-label text-[11px] uppercase tracking-wider text-gold-muted mb-2 block">Event Banner / Photo</label>
                @if($event->image)
                    <div class="mb-3">
                        <img src="{{ asset('storage/'.$event->image) }}" alt="Current banner" 
                             style="max-height:140px;border-radius:6px;border:1px solid var(--gold-mid)/20">
                        <p class="text-[10px] mt-1 opacity-50 uppercase tracking-tighter italic">Current image — upload new to replace</p>
                    </div>
                @endif
                <input type="file" name="image" accept="image/*" class="form-input" style="padding:0.4rem 0.85rem">
                <p class="text-xs mt-1 opacity-50">JPG, PNG or GIF — max 2 MB</p>
            </div>
        </div>
        <div class="flex gap-3 mt-8">
            <button type="submit" class="btn btn-gold px-8 py-3">Update Event</button>
            <a href="{{ route('staff.events.index') }}" class="btn btn-ghost px-8 py-3">Cancel</a>
        </div>
    </form>
</div>
@endsection
