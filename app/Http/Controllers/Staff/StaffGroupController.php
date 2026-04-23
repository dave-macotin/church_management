<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\People\Group;
use App\Models\Ministry\Event;
use Illuminate\Http\Request;

class StaffGroupController extends Controller
{
    public function index(Request $request)
    {
        $query = Group::with('event');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('GroupName', 'like', "%{$search}%")
                  ->orWhere('Description', 'like', "%{$search}%");
            });
        }

        $groups = $query->orderBy('GroupName')->paginate(15)->withQueryString();

        return view('staff.groups.index', compact('groups'));
    }

    public function create()
    {
        $events = Event::orderBy('StartDateTime', 'desc')->get();
        return view('staff.groups.create', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'GroupName'   => 'required|string|max:150',
            'Description' => 'nullable|string',
            'EventID'     => 'nullable|exists:events,EventID',
        ]);

        Group::create($validated);

        return redirect()->route('staff.groups.index')
                         ->with('success', 'Group created successfully.');
    }

    public function show(Group $group)
    {
        $group->load(['event', 'roles']);
        return view('staff.groups.show', compact('group'));
    }

    public function edit(Group $group)
    {
        $events = Event::orderBy('StartDateTime', 'desc')->get();
        return view('staff.groups.edit', compact('group', 'events'));
    }

    public function update(Request $request, Group $group)
    {
        $validated = $request->validate([
            'GroupName'   => 'required|string|max:150',
            'Description' => 'nullable|string',
            'EventID'     => 'nullable|exists:events,EventID',
        ]);

        $group->update($validated);

        return redirect()->route('staff.groups.index')
                         ->with('success', 'Group updated successfully.');
    }
}
