<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ministry\Event;
use App\Models\Ministry\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MemberEventsController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $member = $user->ensureMemberLinked();

        if (!$member) {
            return view('member.events', [
                'upcomingEvents'     => collect(),
                'pastEvents'         => new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10),
                'registeredEventIds' => [],
                'eventAttendances'   => collect(),
            ]);
        }

        // Only show admin-approved events to members
        $upcomingEvents = Event::where('is_approved', true)
            ->where('StartDateTime', '>=', Carbon::today())
            ->orderBy('StartDateTime')
            ->get();

        $pastEvents = Event::where('is_approved', true)
            ->where('StartDateTime', '<', Carbon::today())
            ->orderByDesc('StartDateTime')
            ->paginate(10);

        $registeredEventIds = $member->registeredEvents()->pluck('events.EventID')->toArray();

        $eventAttendances = Attendance::where('MemberID', $member->MemberID)
            ->whereIn('EventID', $upcomingEvents->pluck('EventID'))
            ->get()
            ->keyBy('EventID');

        return view('member.events', compact('upcomingEvents', 'pastEvents', 'registeredEventIds', 'eventAttendances'));
    }

    public function register(Event $event)
    {
        $member = Auth::user()->member;

        if ($event->StartDateTime < Carbon::now()) {
            return redirect()->back()->with('error', 'Cannot register for a past event.');
        }

        if (!$event->is_approved) {
            return redirect()->back()->with('error', 'This event is not yet approved.');
        }

        if (!$member->registeredEvents()->where('event_member.EventID', $event->EventID)->exists()) {
            $member->registeredEvents()->attach($event->EventID, ['registered_at' => now()]);
            Attendance::updateOrCreate(
                ['MemberID' => $member->MemberID, 'EventID' => $event->EventID],
                ['Status' => 'Present', 'Timestamp' => now()]
            );
            return redirect()->back()->with('success', 'You have successfully registered for ' . $event->Title);
        }

        return redirect()->back()->with('info', 'You are already registered for this event.');
    }

    public function checkIn(Event $event)
    {
        $member     = Auth::user()->member;
        $attendance = Attendance::where('MemberID', $member->MemberID)
            ->where('EventID', $event->EventID)->first();

        if ($attendance) {
            $attendance->update(['CheckInTime' => now(), 'Status' => 'Present']);
            return redirect()->back()->with('success', 'Welcome! You have checked in to ' . $event->Title);
        }

        return redirect()->back()->with('error', 'Please register for the event first.');
    }

    public function checkOut(Event $event)
    {
        $member     = Auth::user()->member;
        $attendance = Attendance::where('MemberID', $member->MemberID)
            ->where('EventID', $event->EventID)->first();

        if ($attendance) {
            $attendance->update(['CheckOutTime' => now()]);
            return redirect()->back()->with('success', 'Thank you for attending! You have checked out from ' . $event->Title);
        }

        return redirect()->back()->with('error', 'Attendance record not found.');
    }

    public function cancelRegistration(Event $event)
    {
        $member = Auth::user()->member;
        $member->registeredEvents()->detach($event->EventID);
        Attendance::where('MemberID', $member->MemberID)
            ->where('EventID', $event->EventID)
            ->whereNull('CheckInTime')
            ->delete();

        return redirect()->back()->with('success', 'Your registration for ' . $event->Title . ' has been cancelled.');
    }
}
