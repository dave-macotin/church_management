<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Ministry\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StaffEventController extends Controller
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

        return view('staff.events.index', compact('events'));
    }

    public function create()
    {
        return view('staff.events.create');
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

        // Staff-submitted events need approval
        $validated['is_approved'] = false;
        $validated['submitted_by'] = Auth::id();

        Event::create($validated);

        return redirect()->route('staff.events.index')
                         ->with('success', 'Event submitted for approval.');
    }

    public function show(Event $event)
    {
        $event->load(['groups', 'attendance.member']);
        return view('staff.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('staff.events.edit', compact('event'));
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
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($validated);

        return redirect()->route('staff.events.index')
                         ->with('success', 'Event updated successfully.');
    }
}
