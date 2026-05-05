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

        // Analytics for Charts (Using Collections for DB agnostic compatibility)
        $monthlyGiving = DB::table('donations')
            ->where('Date', '>=', now()->subMonths(5))
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->Date)->format('Ym');
            })
            ->map(function ($group) {
                return (object)[
                    'month' => Carbon::parse($group->first()->Date)->format('M'),
                    'month_sort' => Carbon::parse($group->first()->Date)->format('Ym'),
                    'total' => $group->sum('Amount'),
                ];
            })
            ->sortBy('month_sort')
            ->values();

        $attendanceTrends = DB::table('attendances')
            ->where('Timestamp', '>=', now()->subMonths(5))
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->Timestamp)->format('Ym');
            })
            ->map(function ($group) {
                return (object)[
                    'month' => Carbon::parse($group->first()->Timestamp)->format('M'),
                    'month_sort' => Carbon::parse($group->first()->Timestamp)->format('Ym'),
                    'total' => $group->count(),
                ];
            })
            ->sortBy('month_sort')
            ->values();

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