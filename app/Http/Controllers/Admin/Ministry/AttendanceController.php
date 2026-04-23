<?php

namespace App\Http\Controllers\Admin\Ministry;

use App\Http\Controllers\Controller;
use App\Models\Ministry\Attendance;
use App\Models\People\Member;
use App\Models\Ministry\Event;
use Illuminate\Http\Request;

class AttendanceController extends Controller
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

        return view('admin.Ministry.Attendance.index', compact('attendances'));
    }

    public function create()
    {
        $members = Member::where('Status', 'Active')->orderBy('LastName')->get();
        $events  = Event::orderBy('StartDateTime', 'desc')->limit(20)->get();
        return view('admin.Ministry.Attendance.create', compact('members', 'events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'MemberID'  => 'required|exists:members,MemberID',
            'Status'    => 'required|in:Present,Absent,Excused',
            'Timestamp' => 'required|date',
        ]);

        Attendance::create($validated);

        return redirect()->route('admin.attendance.index')
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

        return redirect()->route('admin.attendance.index')
                         ->with('success', 'Bulk attendance saved.');
    }

    /**
     * Archive (soft-delete) an attendance record.
     */
    public function archive(Attendance $attendance)
    {
        $attendance->delete(); // soft delete via SoftDeletes trait
        return redirect()->route('admin.attendance.index')
                         ->with('success', 'Attendance record archived.');
    }

    /**
     * Show archived records.
     */
    public function archived(Request $request)
    {
        $attendances = Attendance::onlyTrashed()
            ->with('member', 'event')
            ->orderByDesc('deleted_at')
            ->paginate(20);
        return view('admin.Ministry.Attendance.archived', compact('attendances'));
    }

    /**
     * Restore an archived record.
     */
    public function restore($id)
    {
        $attendance = Attendance::onlyTrashed()->findOrFail($id);
        $attendance->restore();
        return redirect()->route('admin.attendance.archived')
                         ->with('success', 'Attendance record restored.');
    }

    // Keep edit/update in Controller but they are no longer surfaced in UI
    public function edit(Attendance $attendance)
    {
        $members = Member::where('Status', 'Active')->orderBy('LastName')->get();
        return view('admin.Ministry.Attendance.edit', compact('attendance', 'members'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'MemberID'  => 'required|exists:members,MemberID',
            'Status'    => 'required|in:Present,Absent,Excused',
            'Timestamp' => 'required|date',
        ]);

        $attendance->update($validated);

        return redirect()->route('admin.attendance.index')
                         ->with('success', 'Attendance updated.');
    }
}
