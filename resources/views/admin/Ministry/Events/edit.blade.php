@extends('admin.Layout.app')
@section('title', 'Edit Event — Grace Church CMS')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.events.index') }}" class="btn btn-ghost" style="padding:0.4rem 0.75rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
    </a>
    <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Edit Event</h1>
</div>

<div class="card p-6 max-w-xl">
    @if($errors->any())
        <div class="alert-error mb-4">
            @foreach($errors->all() as $error)<p class="text-sm">{{ $error }}</p>@endforeach
        </div>
    @endif
    <form method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data">
        @csrf @method('PATCH')
        <div class="flex flex-col gap-4">
            <div>
                <label class="form-label">Title <span style="color:var(--red)">*</span></label>
                <input type="text" name="Title" value="{{ old('Title', $event->Title) }}" class="form-input" required>
            </div>
            <div>
                <label class="form-label">Location</label>
                <input type="text" name="Location" value="{{ old('Location', $event->Location) }}" class="form-input">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Start Date & Time <span style="color:var(--red)">*</span></label>
                    <input type="datetime-local" name="StartDateTime"
                           value="{{ old('StartDateTime', $event->StartDateTime?->format('Y-m-d\TH:i')) }}"
                           class="form-input" required>
                </div>
                <div>
                    <label class="form-label">End Date & Time</label>
                    <input type="datetime-local" name="EndDateTime"
                           value="{{ old('EndDateTime', $event->EndDateTime?->format('Y-m-d\TH:i')) }}"
                           class="form-input">
                </div>
            </div>
            <div>
                <label class="form-label">Event Banner / Photo</label>
                @if($event->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$event->image) }}" alt="Current banner"
                             style="max-height:140px;border-radius:6px;border:1px solid var(--border)">
                        <p class="text-xs mt-1" style="color:var(--text-muted)">Current image — upload a new one to replace it</p>
                    </div>
                @endif
                <input type="file" name="image" accept="image/*" class="form-input" style="padding:0.4rem 0.85rem">
                <p class="text-xs mt-1" style="color:var(--text-muted)">JPG, PNG or GIF — max 2 MB</p>
            </div>
            @if(auth()->user()->role === 'admin')
            <div class="flex items-center gap-3">
                <input type="hidden" name="is_approved" value="0">
                <input type="checkbox" name="is_approved" value="1" id="is_approved"
                       {{ old('is_approved', $event->is_approved ? '1' : '0') == '1' ? 'checked' : '' }}
                       style="width:16px;height:16px;accent-color:var(--gold)">
                <label for="is_approved" class="form-label" style="margin:0">Approved (visible to members)</label>
            </div>
            @endif
        </div>
        <div class="flex gap-3 mt-6">
            <button type="submit" class="btn btn-gold">Update Event</button>
            <a href="{{ route('admin.events.index') }}" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection
