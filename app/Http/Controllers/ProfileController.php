<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show the profile edit page.
     */
    public function edit(): View
    {
        $user   = Auth::user();
        $member = $user->ensureMemberLinked(); 

        $view = request()->routeIs('admin.profile.*') ? 'admin.profile.edit' : 'staff.profile.edit';
        return view($view, compact('user', 'member'));
    }

    /**
     * Update the user's account info (name, email) and profile picture.
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = Auth::user();

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        // Ensure the user is linked to a Member record
        $member = $user->ensureMemberLinked();

        if ($member) {
            $updateData = [
                'FirstName'   => $request->first_name,
                'LastName'    => $request->last_name,
                'PhoneNumber' => $request->phone_number,
                'DateOfBirth' => $request->date_of_birth,
            ];

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
                $updateData['profile_picture'] = $path;
            }

            $member->update($updateData);

            // Sync user first_name and last_name with member if they were updated
            $user->update([
                'first_name' => $request->first_name ?? $user->first_name,
                'last_name'  => $request->last_name ?? $user->last_name,
            ]);
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Current password is incorrect.'])
                ->withInput();
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success_password', 'Password changed successfully.');
    }
}