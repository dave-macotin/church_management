<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\People\Member;
use App\Models\People\Family;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffMemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::with(['family', 'role']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('FirstName', 'like', "%{$search}%")
                  ->orWhere('LastName', 'like', "%{$search}%")
                  ->orWhere('Email', 'like', "%{$search}%")
                  ->orWhere('PhoneNumber', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('Status', $request->status);
        }

        $members = $query->orderBy('LastName')->paginate(15)->withQueryString();

        return view('staff.members.index', compact('members'));
    }

    public function create()
    {
        $families = Family::orderBy('FamilyName')->get();
        $roles    = Role::orderBy('RoleName')->get();
        return view('staff.members.create', compact('families', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'FirstName'   => 'required|string|max:100',
            'LastName'    => 'required|string|max:100',
            'Email'       => 'nullable|email|max:150|unique:members,Email',
            'PhoneNumber' => 'nullable|string|max:20',
            'Status'      => 'required|in:Active,Inactive,Pending',
            'FamilyID'    => 'nullable|exists:families,FamilyID',
            'RoleID'      => 'nullable|exists:roles,RoleID',
            'Password'    => 'nullable|string|min:8',
        ]);

        if (!empty($validated['Password'])) {
            $validated['Password'] = Hash::make($validated['Password']);
        } else {
            unset($validated['Password']);
        }

        Member::create($validated);

        return redirect()->route('staff.members.index')
                         ->with('success', 'Member added successfully.');
    }

    public function show(Member $member)
    {
        $member->load(['family', 'role', 'attendances.event']);
        return view('staff.members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        $families = Family::orderBy('FamilyName')->get();
        $roles    = Role::orderBy('RoleName')->get();
        return view('staff.members.edit', compact('member', 'families', 'roles'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'FirstName'   => 'required|string|max:100',
            'LastName'    => 'required|string|max:100',
            'Email'       => 'nullable|email|max:150|unique:members,Email,' . $member->MemberID . ',MemberID',
            'PhoneNumber' => 'nullable|string|max:20',
            'Status'      => 'required|in:Active,Inactive,Pending',
            'FamilyID'    => 'nullable|exists:families,FamilyID',
            'RoleID'      => 'nullable|exists:roles,RoleID',
            'Password'    => 'nullable|string|min:8',
        ]);

        if (!empty($validated['Password'])) {
            $validated['Password'] = Hash::make($validated['Password']);
        } else {
            unset($validated['Password']);
        }

        $member->update($validated);

        return redirect()->route('staff.members.index')
                         ->with('success', 'Member updated successfully.');
    }
}
