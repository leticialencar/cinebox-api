<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    private function getCloudinary(): Cloudinary
    {
        $cloudinary = new Cloudinary(
            'cloudinary://'.env('CLOUDINARY_KEY').':'.env('CLOUDINARY_SECRET').'@'.env('CLOUDINARY_CLOUD_NAME')
        );

        return $cloudinary;
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($request->hasFile('avatar')) {
            $cloudinary = $this->getCloudinary();

            if ($user->cloudinary_public_id) {
                $cloudinary->uploadApi()->destroy($user->cloudinary_public_id);
            }

            $result = $cloudinary->uploadApi()->upload(
                $request->file('avatar')->getRealPath(),
                ['folder' => 'avatars']
            );

            $user->avatar = $result['secure_url'];
            $user->cloudinary_public_id = $result['public_id'];
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if ($user->cloudinary_public_id) {
            $cloudinary = $this->getCloudinary();
            $cloudinary->uploadApi()->destroy($user->cloudinary_public_id);
        }

        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
