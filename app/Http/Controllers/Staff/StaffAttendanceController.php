<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Ministry\Attendance;
use App\Models\People\Member;
use App\Models\Ministry\Event;
use Illuminate\Http\Request;

class StaffAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('member', 'event');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('member', function ($q) use ($search) {
                $q->where('FirstName', 'like', "%{$search}%")
                  ->orWhere('LastName', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('Status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('Timestamp', $request->date);
        }

        $attendances = $query->orderBy('Timestamp', 'desc')->paginate(20)->withQueryString();

        return view('staff.attendance.index', compact('attendances'));
    }

    public function create()
    {
        $members = Member::where('Status', 'Active')->orderBy('LastName')->get();
        $events  = Event::orderBy('StartDateTime', 'desc')->limit(20)->get();
        return view('staff.attendance.create', compact('members', 'events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'MemberID'  => 'required|exists:members,MemberID',
            'Status'    => 'required|in:Present,Absent,Excused',
            'Timestamp' => 'required|date',
        ]);

        Attendance::create($validated);

        return redirect()->route('staff.attendance.index')
                         ->with('success', 'Attendance recorded.');
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'records'             => 'required|array',
            'records.*.MemberID'  => 'required|exists:members,MemberID',
            'records.*.Status'    => 'required|in:Present,Absent,Excused',
            'Timestamp'           => 'required|date',
        ]);

        $timestamp = $request->Timestamp;

        foreach ($request->records as $record) {
            Attendance::updateOrCreate(
                ['MemberID' => $record['MemberID'], 'Timestamp' => $timestamp],
                ['Status'   => $record['Status']]
            );
        }

        return redirect()->route('staff.attendance.index')
                         ->with('success', 'Bulk attendance saved.');
    }
}
