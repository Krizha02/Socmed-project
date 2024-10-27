<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Show the user's profile
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', ['user' => $user]);
    }

      // Handle profile updates
      public function update(Request $request)
      {
          $request->validate([
              'bio' => 'nullable|string|max:500',
              'address' => 'nullable|string|max:255',
              'phone_number' => 'nullable|string|max:15',
          ]);
  
          $user = Auth::user();
  
          // If the user doesn't have a profile, create a new one
          $profile = $user->profile ?: new UserProfile(['user_id' => $user->id]);
  
          // Update the fields
          $profile->bio = $request->input('bio');
          $profile->address = $request->input('address');
          $profile->phone_number = $request->input('phone_number');
          $profile->save();
  
          return redirect()->back()->with('success', 'Profile updated successfully.');
      }

        // Handle profile picture upload
        // public function upload(Request $request)
        // {
        //     $request->validate([
        //         'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        //     ]);

        //     $user = Auth::user();
        //     $profile = $user->profile ?: new UserProfile(['user_id' => $user->id]);

        //     if ($request->hasFile('profile_picture')) {
        //         // Delete the old profile picture if it exists
        //         if ($profile->profile_picture) {
        //             Storage::delete('public/profile_picture/' . $profile->profile_picture);
        //         }

        //         // Store the new profile picture
        //         $fileName = time() . '.' . $request->profile_picture->extension();
        //         $request->profile_picture->storeAs('public/profile_picture', $fileName);
        //         $profile->profile_picture = $fileName;
        //         $profile->save();
        //     }

        //     return redirect()->back()->with('success', 'Profile picture updated successfully.');
        // }

        public function upload(Request $request)
        {
            $request->validate([
                'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $user = Auth::user();
            $profile = $user->profile ?: new UserProfile(['user_id' => $user->id]);

            if ($request->hasFile('profile_picture')) {
                // Delete the old profile picture if it exists
                if ($profile->profile_picture) {
                    Storage::delete('public/profile_picture/' . $profile->profile_picture);
                }

                // Store the new profile picture
                $fileName = time() . '.' . $request->profile_picture->extension();
                $request->profile_picture->storeAs('public/profile_picture', $fileName);
                $profile->profile_picture = $fileName;
                $profile->save();
            }

            return redirect()->back()->with('success', 'Profile picture updated successfully.');
        }
}
