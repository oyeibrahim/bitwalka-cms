<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    //
    /**
     * Update the user's profile picture.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = User::find(Auth::id());

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1048576',
        ]);

        if ($request->hasFile('image')) {
            if ($request->file('image')->getSize() > 1048576) {
                return redirect()->back()->with('status', 'image-size-exceeded');
            }

            // delete previous image
            Storage::delete($user->image);

            $image = $request->file('image')->store('public/profile');

            $user->image = $image;

            $user->save();

            return Redirect::route('profile.edit')->with('status', 'image-updated');
        } else {
            return redirect()->back()->with('status', 'no-image-selected');
        }
    }
}
