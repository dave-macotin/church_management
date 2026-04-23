<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ministry\Event;
use App\Models\Finance\Donations;
use App\Models\Ministry\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MemberDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $member = $user->ensureMemberLinked();

        if (!$member) {
            return view('member.dashboard', [
                'attendanceRate' => 0,
                'presentCount' => 0,
                'absentCount' => 0,
                'excusedCount' => 0,
                'upcomingCount' => 0,
                'groupCount' => 0,
                'totalDonations' => 0,
                'upcomingEvents' => collect(),
                'recentAttendance' => collect(),
                'myGroups' => [],
                'recentDonations' => collect(),
                'family' => null,
                'familyMemberCount' => 0
            ]);
        }

        // Attendance stats
        $totalAttendances = $member->attendances()->count();
        $presentCount = $member->attendances()->where('Status', 'Present')->count();
        $absentCount = $member->attendances()->where('Status', 'Absent')->count();
        $excusedCount = $member->attendances()->where('Status', 'Excused')->count();
        $attendanceRate = $totalAttendances > 0 ? round(($presentCount / $totalAttendances) * 100) : 0;

        // Giving stats
        $totalDonations = $member->donations()->sum('Amount');
        $recentDonations = $member->donations()->orderByDesc('Date')->take(5)->get();

        // Events stats
        $upcomingEvents = Event::where('StartDateTime', '>=', Carbon::today())
            ->orderBy('StartDateTime')
            ->take(5)
            ->get();
        $upcomingCount = Event::where('StartDateTime', '>=', Carbon::today())->count();

        // Group stats
        $groupCount = 0;
        $myGroups = [];
        if ($member->role && $member->role->group) {
            $myGroups = [$member->role->group];
            $groupCount = 1;
        }

        // Recent attendance
        $recentAttendance = $member->attendances()
            ->with('event')
            ->orderByDesc('Timestamp')
            ->take(5)
            ->get();

        // Family info
        $family = $member->family;
        $familyMemberCount = $family ? $family->members()->count() : 0;

        return view('member.dashboard', compact(
            'attendanceRate',
            'presentCount',
            'absentCount',
            'excusedCount',
            'totalDonations',
            'recentDonations',
            'upcomingEvents',
            'upcomingCount',
            'groupCount',
            'myGroups',
            'recentAttendance',
            'family',
            'familyMemberCount'
        ));
    }

    public function donations()
    {
        return redirect()->route('member.donations');
    }
}