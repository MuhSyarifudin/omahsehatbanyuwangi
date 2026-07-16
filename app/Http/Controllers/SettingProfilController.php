<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\UserProfilePhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class SettingProfilController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $profilePhotos = $user->profilePhotos()
            ->latest()
            ->get();

        if ($user->avatar && !$profilePhotos->contains('path', $user->avatar)) {
            $profilePhotos->prepend(new UserProfilePhoto([
                'user_id' => $user->id,
                'path' => $user->avatar,
            ]));
        }

        return view('settings.index', [
            'user' => $user,
            'profilePhotos' => $profilePhotos,
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

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            $user->profilePhotos()->firstOrCreate([
                'path' => $user->avatar,
            ]);
        }

        $user->avatar = $path;
        $user->save();

        $user->profilePhotos()->firstOrCreate([
            'path' => $path,
        ]);
    
        return response()->json([
            'url' => Storage::url($path),
            'path' => $path,
        ]);
    }

    public function selectPhoto(Request $request)
    {
        $validated = $request->validate([
            'path' => 'required|string',
        ]);

        $user = $request->user();
        $photo = $user->profilePhotos()
            ->where('path', $validated['path'])
            ->firstOrFail();

        if (!Storage::disk('public')->exists($photo->path)) {
            abort(404, 'Foto profile tidak ditemukan.');
        }

        $user->avatar = $photo->path;
        $user->save();

        return response()->json([
            'url' => Storage::url($photo->path),
            'path' => $photo->path,
        ]);
    }

    public function deletePhoto(Request $request)
    {
        $validated = $request->validate([
            'path' => 'required|string',
        ]);

        $path = $this->normalizeStoredPath($validated['path']);

        if (str_contains($path, '..') || !str_starts_with($path, 'profiles/')) {
            abort(403);
        }

        $user = $request->user();

        $ownedPaths = $user->profilePhotos()
            ->pluck('path')
            ->map(fn (string $storedPath) => $this->normalizeStoredPath($storedPath))
            ->when($user->avatar, fn ($paths) => $paths->push($this->normalizeStoredPath($user->avatar)))
            ->unique();

        if (!$ownedPaths->contains($path)) {
            abort(403);
        }

        if ($this->normalizeStoredPath((string) $user->avatar) === $path) {
            $nextPhoto = $user->profilePhotos()
                ->where('path', '!=', $path)
                ->latest()
                ->first();

            $user->avatar = ($nextPhoto && Storage::disk('public')->exists($nextPhoto->path))
                ? $nextPhoto->path
                : null;
            $user->save();
        }

        $user->profilePhotos()->where('path', $path)->delete();

        $fileDeleted = $this->deleteStoredFile($path);

        return response()->json([
            'path' => $path,
            'file_deleted' => $fileDeleted,
            'avatar' => $user->avatar,
            'avatar_url' => $user->avatar
                ? Storage::url($user->avatar)
                : asset('assets/img/blank-profile.png'),
        ]);
    }

    private function normalizeStoredPath(string $path): string
    {
        $path = str_replace('\\', '/', trim($path));
        $path = ltrim($path, '/');

        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, strlen('storage/'));
        }

        return $path;
    }

    private function deleteStoredFile(string $path): bool
    {
        $deleted = Storage::disk('public')->delete($path);

        $fullPath = Storage::disk('public')->path($path);

        if (is_file($fullPath)) {
            $deleted = @unlink($fullPath) || $deleted;
        }

        return $deleted;
    }

    public function updateBackground(Request $request)
    {
        $request->validate([
            'background' => 'required|image|max:4096'
        ]);

        $user = $request->user();
        $oldBackground = $user->background
            ? $this->normalizeStoredPath($user->background)
            : null;

        $manager = new ImageManager(new Driver());

        $image = $manager
            ->read($request->file('background'))
            ->cover(1600, 700)
            ->toJpeg(90);

        $filename = (string) Str::uuid() . '.jpg';
        $path = 'background/' . $filename;

        Storage::disk('public')->put($path, (string) $image);

        $user->background = $path;
        $user->save();

        if (
            $oldBackground
            && $oldBackground !== $path
            && str_starts_with($oldBackground, 'background/')
        ) {
            $this->deleteStoredFile($oldBackground);
        }

        return response()->json([
            'url' => Storage::url($path),
            'background' => $path,
        ]);
    }

}
