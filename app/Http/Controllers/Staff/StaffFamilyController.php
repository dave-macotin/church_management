<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\People\Family;
use App\Models\People\Member;
use Illuminate\Http\Request;

class StaffFamilyController extends Controller
{
    public function index(Request $request)
    {
        $query = Family::with(['headMember', 'members']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('FamilyName', 'like', "%{$search}%")
                  ->orWhere('HomeAddress', 'like', "%{$search}%")
                  ->orWhere('PhoneNumber', 'like', "%{$search}%");
            });
        }

        $families = $query->orderBy('FamilyName')->paginate(15)->withQueryString();

        return view('staff.families.index', compact('families'));
    }

    public function create()
    {
        $members = Member::orderBy('LastName')->get();
        return view('staff.families.create', compact('members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'FamilyName'  => 'required|string|max:150',
            'HomeAddress' => 'nullable|string|max:255',
            'PhoneNumber' => 'nullable|string|max:20',
            'MemberID'    => 'nullable|exists:members,MemberID',
        ]);

        Family::create($validated);

        return redirect()->route('staff.families.index')
                         ->with('success', 'Family added successfully.');
    }

    public function show(Family $family)
    {
        $family->load(['headMember', 'members.role']);
        return view('staff.families.show', compact('family'));
    }
}
