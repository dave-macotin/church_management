<?php

namespace App\Http\Controllers\Admin\People;

use App\Http\Controllers\Controller;
use App\Models\People\Member;
use App\Models\People\Family;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
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

        return view('admin.People.Members.index', compact('members'));
    }

    public function create()
    {
        $families = Family::orderBy('FamilyName')->get();
        $roles    = Role::orderBy('RoleName')->get();
        return view('admin.People.Members.create', compact('families', 'roles'));
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

        $member = Member::create($validated);

        // Synchronize with Users table for login credentials
        if (!empty($request->Password)) {
            User::updateOrCreate(
                ['email' => $member->Email],
                [
                    'name'        => $member->FirstName . ' ' . $member->LastName,
                    'first_name'  => $member->FirstName,
                    'last_name'   => $member->LastName,
                    'password'    => Hash::make($request->Password),
                    'role'        => 'member', // Default role for members
                    'is_approved' => true,
                    'MemberID'    => $member->MemberID,
                ]
            );
        }

        return redirect()->route('admin.members.index')
                         ->with('success', 'Member added successfully.');
    }

    public function show(Member $member)
    {
        // Attendance belongs to a Member; Event belongsTo Attendance (not the other way).
        // Load attendances, and each attendance's linked event via hasOne.
        $member->load(['family', 'role', 'attendances.event']);
        return view('admin.People.Members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        $families = Family::orderBy('FamilyName')->get();
        $roles    = Role::orderBy('RoleName')->get();
        return view('admin.People.Members.edit', compact('member', 'families', 'roles'));
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

        // Synchronize with Users table for login credentials
        if (!empty($request->Password)) {
            User::updateOrCreate(
                ['email' => $member->Email],
                [
                    'name'        => $member->FirstName . ' ' . $member->LastName,
                    'first_name'  => $member->FirstName,
                    'last_name'   => $member->LastName,
                    'password'    => Hash::make($request->Password),
                    'MemberID'    => $member->MemberID,
                    // Note: We don't overwrite role or approval status on update
                ]
            );
        }

        return redirect()->route('admin.members.index')
                         ->with('success', 'Member updated successfully.');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('admin.members.index')
                         ->with('success', 'Member deleted.');
    }
}
