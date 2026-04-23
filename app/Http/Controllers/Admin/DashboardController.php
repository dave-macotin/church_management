<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMembers   = DB::table('members')->count();
        $totalDonations = DB::table('donations')->sum('Amount');
        $totalExpenses  = DB::table('expenses')->sum('Amount');
        $upcomingEvents = DB::table('events')
                            ->where('StartDateTime', '>=', now())
                            ->count();

        $recentMembers = DB::table('members')
                            ->orderByDesc('created_at')
                            ->limit(5)
                            ->get()
                            ->map(function ($member) {
                                $member->created_at = $member->created_at 
                                    ? Carbon::parse($member->created_at) 
                                    : null;
                                return $member;
                            });

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

        $recentDonations = DB::table('donations')
                            ->orderByDesc('created_at')
                            ->limit(5)
                            ->get()
                            ->map(function ($donation) {
                                $donation->Date = $donation->Date 
                                    ? Carbon::parse($donation->Date) 
                                    : null;
                                return $donation;
                            });

        $pendingUsers = User::whereNull('MemberID')
                            ->orderByDesc('created_at')
                            ->limit(5)
                            ->get();

        // Analytics for Charts
        $monthlyGiving = DB::table('donations')
            ->select(DB::raw("DATE_FORMAT(Date, '%b') as month"), DB::raw("SUM(Amount) as total"))
            ->where('Date', '>=', now()->subMonths(5))
            ->groupBy('month')
            ->orderBy('Date')
            ->get();

        $attendanceTrends = DB::table('attendances')
            ->select(DB::raw("DATE_FORMAT(Timestamp, '%b') as month"), DB::raw("COUNT(*) as total"))
            ->where('Timestamp', '>=', now()->subMonths(5))
            ->groupBy('month')
            ->orderBy('Timestamp')
            ->get();

        return view('admin.dashboard', compact(
            'totalMembers',
            'totalDonations',
            'totalExpenses',
            'upcomingEvents',
            'recentMembers',
            'nextEvents',
            'recentDonations',
            'pendingUsers',
            'monthlyGiving',
            'attendanceTrends',
        ));
    }
}