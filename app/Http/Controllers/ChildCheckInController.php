<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Child;
use App\Models\ChildCheckIn;
use Illuminate\Support\Str;

class ChildCheckInController extends Controller
{
    // Parent View
    public function index()
    {
        $member = auth()->user()->member;
        if (!$member) abort(403);

        $children = Child::where('parent_id', $member->MemberID)->get();
        return view('member.children.index', compact('children'));
    }

    public function storeChild(Request $request)
    {
        $member = auth()->user()->member;
        $data = $request->validate([
            'FirstName'    => 'required|string',
            'LastName'     => 'required|string',
            'BirthDate'    => 'required|date',
            'MedicalNotes' => 'nullable|string',
        ]);

        $data['parent_id'] = $member->MemberID;
        $data['PickupCode'] = strtoupper(Str::random(6));

        Child::create($data);

        return back()->with('success', 'Child registered successfully!');
    }

    // Staff/Admin Check-In View
    public function kiosk()
    {
        return view('admin.Ministry.CheckIn.kiosk');
    }

    public function process(Request $request)
    {
        $request->validate([
            'pickup_code' => 'required|string',
            'type'        => 'required|in:check-in,check-out',
        ]);

        $child = Child::where('PickupCode', $request->pickup_code)->first();

        if (!$child) {
            return back()->with('error', 'Invalid Pickup Code. Please check and try again.');
        }

        ChildCheckIn::create([
            'child_id'   => $child->id,
            'parent_id'  => $child->parent_id,
            'type'       => $request->type,
            'timestamp'  => now(),
            'session_name' => 'Service ' . now()->format('Y-m-d'),
        ]);

        $message = $request->type === 'check-in' 
            ? "{$child->FirstName} has been checked in." 
            : "{$child->FirstName} has been checked out.";

        return back()->with('success', $message);
    }
}
