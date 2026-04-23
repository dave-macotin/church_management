@extends($layout)
@section('title', 'Compose Message — ' . App\Models\Setting::get('church_name', 'Grace Church'))

@section('content')
<div class="mb-6">
    <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Compose Message</h1>
    <p class="text-sm mt-1" style="color:var(--text-muted)">Send a new message to a member or staff</p>
</div>

<div class="card p-6 max-w-2xl">
    <form method="POST" action="{{ route('messages.store') }}">
        @csrf
        
        <div class="mb-4">
            <label class="form-label">Recipient</label>
            <select name="receiver_id" class="form-input" required>
                <option value="">Select a recipient...</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ ucfirst($user->role) }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="form-label">Subject</label>
            <input type="text" name="subject" class="form-input" required placeholder="Subject of your message">
        </div>

        <div class="mb-6">
            <label class="form-label">Message Content</label>
            <textarea name="content" class="form-input" rows="8" required placeholder="Write your message here..."></textarea>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('messages.index') }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-gold px-8">Send Message</button>
        </div>
    </form>
</div>
@endsection
