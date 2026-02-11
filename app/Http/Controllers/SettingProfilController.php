<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\View\View;

class SettingProfilController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('settings.index', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('settings.edit')->with('status', 'profile-updated');
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

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048'
        ]);
    
        $manager = new ImageManager(new Driver());
    
        $image = $manager
            ->read($request->file('photo'))
            ->cover(500, 500)
            ->toJpeg(90);
    
        $filename = 'profile_' . Str::random(20) . '.jpg';
        $path = 'profiles/' . $filename;
    
        Storage::disk('public')->put($path, (string) $image);
    
        $user = $request->user();
    
        if ($user->avatars) {
            Storage::disk('public')->delete($user->avatars);
        }
    
        $user->avatars = $path;
        $user->save();
    
        return response()->json([
            'url' => Storage::url($path)
        ]);
    }

}
