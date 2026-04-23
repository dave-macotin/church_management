<?php

namespace App\Http\Controllers\Admin\Ministry;

use App\Http\Controllers\Controller;
use App\Models\Ministry\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('Title', 'like', "%{$search}%")
                  ->orWhere('Location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('filter')) {
            if ($request->filter === 'upcoming') {
                $query->where('StartDateTime', '>=', now());
            } elseif ($request->filter === 'past') {
                $query->where('StartDateTime', '<', now());
            } elseif ($request->filter === 'pending') {
                $query->where('is_approved', false);
            } elseif ($request->filter === 'approved') {
                $query->where('is_approved', true);
            }
        }

        $events = $query->orderBy('StartDateTime', 'desc')->paginate(15)->withQueryString();

        return view('admin.Ministry.Events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.Ministry.Events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Title'         => 'required|string|max:150',
            'Location'      => 'nullable|string|max:255',
            'StartDateTime' => 'required|date',
            'EndDateTime'   => 'nullable|date|after_or_equal:StartDateTime',
            'image'         => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        // Admin-submitted events are auto-approved
        $validated['is_approved'] = Auth::user()->role === 'admin';
        $validated['submitted_by'] = Auth::id();

        Event::create($validated);

        return redirect()->route('admin.events.index')
                         ->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        $event->load(['groups', 'attendance.member']);
        return view('admin.Ministry.Events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('admin.Ministry.Events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'Title'         => 'required|string|max:150',
            'Location'      => 'nullable|string|max:255',
            'StartDateTime' => 'required|date',
            'EndDateTime'   => 'nullable|date|after_or_equal:StartDateTime',
            'image'         => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')
                         ->with('success', 'Event updated successfully.');
    }

    /**
     * Admin approves a pending event.
     */
    public function approve(Event $event)
    {
        $event->update(['is_approved' => true]);
        return redirect()->back()->with('success', "'{$event->Title}' has been approved.");
    }

    public function destroy(Event $event)
    {
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }
        $event->delete();
        return redirect()->route('admin.events.index')
                         ->with('success', 'Event deleted.');
    }
}
