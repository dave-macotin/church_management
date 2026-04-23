<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StaffDashboardController extends Controller
{
    public function index()
    {
        // ── Counts ────────────────────────────────────────────────────────
        $totalMembers   = DB::table('members')->count();
        $totalDonations = DB::table('donations')->sum('Amount');
        $totalExpenses  = DB::table('expenses')->sum('Amount');

        $upcomingEvents = DB::table('events')
                            ->where('StartDateTime', '>=', now())
                            ->count();

        $todayAttendance = DB::table('attendances')
                            ->whereDate('Timestamp', today())
                            ->where('Status', 'Present')
                            ->count();

        // ── Recent Members (latest 5) ─────────────────────────────────────
        $recentMembers = DB::table('members')
                            ->orderByDesc('created_at')
                            ->limit(5)
                            ->get();

        // ── Upcoming Events (next 5) ──────────────────────────────────────
        $nextEvents = DB::table('events')
                            ->where('StartDateTime', '>=', now())
                            ->orderBy('StartDateTime')
                            ->limit(5)
                            ->get()
                            ->map(function ($event) {
                                $event->StartDateTime = $event->StartDateTime
                                    ? Carbon::parse($event->StartDateTime)
                                    : null;
                                return $event;
                            });

        // ── Recent Attendance (latest 8, joined with member name) ─────────
        $recentAttendance = DB::table('attendances')
                            ->leftJoin('members', 'attendances.MemberID', '=', 'members.MemberID')
                            ->select(
                                'attendances.*',
                                DB::raw("CONCAT(members.FirstName, ' ', members.LastName) AS member_name")
                            )
                            ->orderByDesc('attendances.Timestamp')
                            ->limit(8)
                            ->get();

        // ── Recent Donations (latest 5) ───────────────────────────────────
        $recentDonations = DB::table('donations')
                            ->orderByDesc('Date')
                            ->limit(5)
                            ->get()
                            ->map(function ($donation) {
                                $donation->Date = $donation->Date
                                    ? Carbon::parse($donation->Date)
                                    : null;
                                return $donation;
                            });

        // ── Pending user approvals (unapproved, non-admin limit 5) ────────
        $pendingUsers = User::where('is_approved', false)
                            ->orderByDesc('created_at')
                            ->limit(5)
                            ->get();

        return view('staff.dashboard', compact(
            'totalMembers',
            'totalDonations',
            'totalExpenses',
            'upcomingEvents',
            'todayAttendance',
            'recentMembers',
            'nextEvents',
            'recentAttendance',
            'recentDonations',
            'pendingUsers',
        ));
    }
}