<?php

namespace App\Http\Controllers\Admin\People;

use App\Http\Controllers\Controller;
use App\Models\People\Family;
use App\Models\People\Member;
use Illuminate\Http\Request;

class FamilyController extends Controller
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

        return view('admin.People.Families.index', compact('families'));
    }

    public function create()
    {
        $members = Member::orderBy('LastName')->get();
        return view('admin.People.Families.create', compact('members'));
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

        return redirect()->route('admin.families.index')
                         ->with('success', 'Family added successfully.');
    }

    public function show(Family $family)
    {
        $family->load(['headMember', 'members.role']);
        return view('admin.People.Families.show', compact('family'));
    }

    public function edit(Family $family)
    {
        $members = Member::orderBy('LastName')->get();
        return view('admin.People.Families.edit', compact('family', 'members'));
    }

    public function update(Request $request, Family $family)
    {
        $validated = $request->validate([
            'FamilyName'  => 'required|string|max:150',
            'HomeAddress' => 'nullable|string|max:255',
            'PhoneNumber' => 'nullable|string|max:20',
            'MemberID'    => 'nullable|exists:members,MemberID',
        ]);

        $family->update($validated);

        return redirect()->route('admin.families.index')
                         ->with('success', 'Family updated successfully.');
    }

    public function destroy(Family $family)
    {
        $family->delete();
        return redirect()->route('admin.families.index')
                         ->with('success', 'Family deleted.');
    }
}
