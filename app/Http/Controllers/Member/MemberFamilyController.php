<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberFamilyController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $member = $user->ensureMemberLinked();
        
        if (!$member) {
            return view('member.family', ['family' => null, 'familyMembers' => collect()]);
        }

        $family = $member->family;
        $familyMembers = $family ? $family->members : collect();

        return view('member.family', compact('family', 'familyMembers'));
    }
}
