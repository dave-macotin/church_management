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
        $layout = auth()->user()->role === 'admin' ? 'admin.Layout.app' : (auth()->user()->role === 'staff' ? 'staff.layout.app' : 'member.layout.app');
        $messages = Message::where('receiver_id', auth()->id())
            ->with('sender')
            ->latest()
            ->paginate(15);

        return view('messages.index', compact('messages', 'layout'));
    }

    public function create()
    {
        $layout = auth()->user()->role === 'admin' ? 'admin.Layout.app' : (auth()->user()->role === 'staff' ? 'staff.layout.app' : 'member.layout.app');
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
        $layout = auth()->user()->role === 'admin' ? 'admin.Layout.app' : (auth()->user()->role === 'staff' ? 'staff.layout.app' : 'member.layout.app');
        if ($message->receiver_id !== auth()->id() && $message->sender_id !== auth()->id()) {
            abort(403);
        }

        if ($message->receiver_id === auth()->id() && !$message->read_at) {
            $message->update(['read_at' => now()]);
        }

        return view('messages.show', compact('message', 'layout'));
    }
}
