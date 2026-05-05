<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;

class MessagesController extends Controller
{
    public function index()
    {
        $layout = $this->layoutFor(auth()->user()->role);
        $messages = Message::where('receiver_id', auth()->id())
            ->with('sender')
            ->latest()
            ->paginate(15);

        return view('messages.index', compact('messages', 'layout'));
    }

    public function create()
    {
        $layout = $this->layoutFor(auth()->user()->role);
        $users = User::where('id', '!=', auth()->id())->get();
        return view('messages.create', compact('users', 'layout'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'subject'     => 'required|string|max:255',
            'content'     => 'required|string',
        ]);

        Message::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'subject'     => $request->subject,
            'content'     => $request->content,
        ]);

        return redirect()->route('messages.index')->with('success', 'Message sent successfully!');
    }

    public function show(Message $message)
    {
        $layout = $this->layoutFor(auth()->user()->role);
        if ($message->receiver_id !== auth()->id() && $message->sender_id !== auth()->id()) {
            abort(403);
        }

        if ($message->receiver_id === auth()->id() && !$message->read_at) {
            $message->update(['read_at' => now()]);
        }

        return view('messages.show', compact('message', 'layout'));
    }

    private function layoutFor(string $role): string
    {
        return match($role) {
            'admin' => 'admin.layout.app',
            'staff' => 'staff.layout.app',
            default => 'member.layout.app',
        };
    }
}
