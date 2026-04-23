<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\People\Group;

class MemberGroupsController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $member = $user->ensureMemberLinked();

        // All active groups
        $groups = Group::orderBy('GroupName')->get();

        // IDs this member has joined
        $joinedIds = $member
            ? $member->joinedGroups()->pluck('groups.GroupID')->toArray()
            : [];

        return view('member.groups', compact('groups', 'joinedIds'));
    }

    public function join(Group $group)
    {
        $member = Auth::user()->ensureMemberLinked();
        if (!$member) return back()->with('error', 'Member profile not found.');

        $already = $member->joinedGroups()->where('groups.GroupID', $group->GroupID)->exists();
        if (!$already) {
            $member->joinedGroups()->attach($group->GroupID, ['joined_at' => now()]);
        }

        return back()->with('success', "You've joined {$group->GroupName}!");
    }

    public function leave(Group $group)
    {
        $member = Auth::user()->ensureMemberLinked();
        if (!$member) return back()->with('error', 'Member profile not found.');

        $member->joinedGroups()->detach($group->GroupID);

        return back()->with('success', "You've left {$group->GroupName}.");
    }
}
