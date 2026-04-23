@extends($layout)
@section('title', 'Read Message — ' . App\Models\Setting::get('church_name', 'Grace Church'))

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="font-cinzel text-2xl" style="color:var(--gold)">{{ $message->subject }}</h1>
        <p class="text-sm mt-1" style="color:var(--text-muted)">From: {{ $message->sender->name }}</p>
    </div>
    <a href="{{ route('messages.index') }}" class="btn btn-ghost px-4">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Back to Inbox
    </a>
</div>

<div class="card p-8">
    <div class="flex justify-between items-start mb-8 pb-4 border-b border-white/5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-amber-900/40 flex items-center justify-center text-sm font-bold" style="color:var(--gold)">
                {{ substr($message->sender->name, 0, 1) }}
            </div>
            <div>
                <div class="font-bold">{{ $message->sender->name }}</div>
                <div class="text-xs" style="color:var(--text-muted)">{{ $message->sender->email }}</div>
            </div>
        </div>
        <div class="text-xs text-right" style="color:var(--text-muted)">
            Sent on {{ $message->created_at->format('M d, Y') }}<br>
            at {{ $message->created_at->format('h:i A') }}
        </div>
    </div>

    <div class="text-sm leading-relaxed whitespace-pre-wrap text-main" style="color:var(--text-main)">{{ $message->content }}</div>

    <div class="mt-12 pt-6 border-t border-white/5 flex gap-3">
        @if($message->receiver_id == auth()->id())
            <a href="{{ route('messages.create', ['receiver_id' => $message->sender_id, 'subject' => 'Re: ' . $message->subject]) }}" class="btn btn-gold px-8">Reply</a>
        @endif
        <button onclick="window.print()" class="btn btn-ghost">Print Message</button>
    </div>
</div>
@endsection
