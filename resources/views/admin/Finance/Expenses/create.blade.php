@extends('admin.layout.app')
@section('title', 'Add Expense — Grace Church CMS')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.expenses.index') }}" class="btn btn-ghost" style="padding:0.4rem 0.75rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
    </a>
    <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Add Expense</h1>
</div>

<div class="card p-6 max-w-xl">
    @if($errors->any())
        <div class="alert-error mb-4">
            @foreach($errors->all() as $error)<p class="text-sm">{{ $error }}</p>@endforeach
        </div>
    @endif
    <form method="POST" action="{{ route('admin.expenses.store') }}">
        @csrf
        <div class="flex flex-col gap-4">
            <div>
                <label class="form-label">Category</label>
                <input type="text" name="Category" value="{{ old('Category') }}" class="form-input" placeholder="e.g. Sound System, Catering">
            </div>
            <div>
                <label class="form-label">Amount <span style="color:var(--red)">*</span></label>
                <input type="number" step="0.01" name="Amount" value="{{ old('Amount') }}" class="form-input" required min="0">
            </div>
            <div>
                <label class="form-label">Vendor / Payee</label>
                <input type="text" name="Vendor" value="{{ old('Vendor') }}" class="form-input">
            </div>
            <div>
                <label class="form-label">For Event (optional)</label>
                <select name="EventID" class="form-input">
                    <option value="">— General / Not Event-Specific —</option>
                    @foreach($events as $event)
                        <option value="{{ $event->EventID }}" {{ old('EventID') == $event->EventID ? 'selected' : '' }}>
                            {{ $event->Title }} — {{ $event->StartDateTime?->format('M d, Y') }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs mt-1" style="color:var(--text-muted)">Link this expense to a specific approved event funded by donations.</p>
            </div>
        </div>
        <div class="flex gap-3 mt-6">
            <button type="submit" class="btn btn-gold">Record Expense</button>
            <a href="{{ route('admin.expenses.index') }}" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection
