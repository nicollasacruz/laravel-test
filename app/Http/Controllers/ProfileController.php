<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Update the user's avatar.
     */
    public function updateAvatar()
    {
        $this->validate(request(), [
            'avatar' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:1024',
            ]);

        $user = User::find(auth()->id());

        $user->update([
            'avatar' => request()->file('avatar')->store('avatars', 'public'),
        ]);

        return back();
    }
}
