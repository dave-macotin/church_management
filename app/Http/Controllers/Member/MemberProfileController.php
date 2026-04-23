<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MemberProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $member = $user->ensureMemberLinked();
        
        if (!$member) {
            return redirect()->route('member.dashboard')->with('error', 'Member profile could not be created or linked.');
        }

        return view('member.profile', compact('member'));
    }

    public function update(Request $request)
    {
        $member = Auth::user()->member;
        
        $validated = $request->validate([
            'FirstName'       => 'required|string|max:100',
            'LastName'        => 'required|string|max:100',
            'Email'           => 'required|email|max:150|unique:members,Email,' . $member->MemberID . ',MemberID',
            'PhoneNumber'     => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            // Ensure storage directory exists
            if (!Storage::disk('public')->exists('profiles')) {
                Storage::disk('public')->makeDirectory('profiles');
            }

            // Delete old picture if exists
            if ($member->profile_picture && Storage::disk('public')->exists($member->profile_picture)) {
                Storage::disk('public')->delete($member->profile_picture);
            }
            
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('profiles', $filename, 'public');
            $validated['profile_picture'] = $path;
        }

        $member->update($validated);

        // Sync with User account
        $user = Auth::user();
        $user->update([
            'first_name' => $validated['FirstName'],
            'last_name'  => $validated['LastName'],
            'name'       => $validated['FirstName'] . ' ' . $validated['LastName'],
            'email'      => $validated['Email'],
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
