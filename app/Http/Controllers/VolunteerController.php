<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VolunteerOpportunity;
use App\Models\VolunteerRegistration;

class VolunteerController extends Controller
{
    // Member Views
    public function index()
    {
        $opportunities = VolunteerOpportunity::where('is_active', true)
            ->where('date', '>=', now()->toDateString())
            ->latest()
            ->get();

        $myRegistrations = VolunteerRegistration::where('member_id', auth()->user()->member->MemberID)->pluck('opportunity_id')->toArray();

        return view('member.volunteering.index', compact('opportunities', 'myRegistrations'));
    }

    public function signup(VolunteerOpportunity $opportunity)
    {
        $member = auth()->user()->member;
        
        // Check if already signed up
        $exists = VolunteerRegistration::where('opportunity_id', $opportunity->id)
            ->where('member_id', $member->MemberID)
            ->exists();

        if ($exists) {
            return back()->with('error', 'You are already registered for this opportunity.');
        }

        VolunteerRegistration::create([
            'opportunity_id' => $opportunity->id,
            'member_id'      => $member->MemberID,
            'status'         => 'pending',
        ]);

        return back()->with('success', 'Thank you for volunteering! Your registration is pending approval.');
    }

    // Admin Views
    public function adminIndex()
    {
        $opportunities = VolunteerOpportunity::withCount('registrations')->latest()->paginate(10);
        return view('admin.Operations.Volunteering.index', compact('opportunities'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'required|string',
            'category'          => 'nullable|string',
            'date'              => 'nullable|date',
            'time_slot'         => 'nullable|string',
            'needed_volunteers' => 'required|integer|min:1',
        ]);

        VolunteerOpportunity::create($data);

        return back()->with('success', 'Volunteer opportunity created successfully!');
    }
}
