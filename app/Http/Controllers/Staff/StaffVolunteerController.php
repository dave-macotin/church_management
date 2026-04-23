<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\VolunteerOpportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffVolunteerController extends Controller
{
    public function index()
    {
        $opportunities = VolunteerOpportunity::withCount('registrations')->latest()->paginate(10);
        return view('staff.volunteering.index', compact('opportunities'));
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

        $data['is_approved'] = false;
        $data['submitted_by'] = Auth::id();

        VolunteerOpportunity::create($data);

        return redirect()->route('staff.volunteering.index')
                         ->with('success', 'Volunteer opportunity submitted for admin approval!');
    }
}
