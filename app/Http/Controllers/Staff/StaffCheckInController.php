<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Child;
use App\Models\ChildCheckIn;
use Illuminate\Support\Str;

class StaffCheckInController extends Controller
{
    public function kiosk()
    {
        return view('staff.checkin.kiosk');
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
