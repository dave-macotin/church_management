@extends('admin.Layout.app')
@section('title', 'Edit Group — Grace Church CMS')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.groups.index') }}" class="btn btn-ghost" style="padding:0.4rem 0.75rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
    </a>
    <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Edit Group</h1>
</div>

<div class="card p-6 max-w-xl">
    @if($errors->any())
        <div class="alert-error mb-4">
            @foreach($errors->all() as $error)<p class="text-sm">{{ $error }}</p>@endforeach
        </div>
    @endif
    <form method="POST" action="{{ route('admin.groups.update', $group) }}">
        @csrf @method('PATCH')
        <div class="flex flex-col gap-4">
            <div>
                <label class="form-label">Group Name <span style="color:var(--red)">*</span></label>
                <input type="text" name="GroupName" value="{{ old('GroupName', $group->GroupName) }}" class="form-input" required>
            </div>
            <div>
                <label class="form-label">Description</label>
                <textarea name="Description" rows="3" class="form-input" style="resize:vertical">{{ old('Description', $group->Description) }}</textarea>
            </div>
            <div>
                <label class="form-label">Linked Event (optional)</label>
                <select name="EventID" class="form-input">
                    <option value="">— None —</option>
                    @foreach($events as $event)
                        <option value="{{ $event->EventID }}" {{ old('EventID', $group->EventID) == $event->EventID ? 'selected' : '' }}>
                            {{ $event->Title }} — {{ $event->StartDateTime?->format('M d, Y') }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex gap-3 mt-6">
            <button type="submit" class="btn btn-gold">Update Group</button>
            <a href="{{ route('admin.groups.index') }}" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection
