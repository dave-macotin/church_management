<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberAttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $member = $user->ensureMemberLinked();

        if (!$member) {
            return view('member.attendance', [
                'attendances' => new \Illuminate\Pagination\LengthAwarePaginator([], 0, 15)
            ]);
        }

        $attendances = $member->attendances()
            ->with(['event'])
            ->orderByDesc('Timestamp')
            ->paginate(15);

        return view('member.attendance', compact('attendances'));
    }
}
