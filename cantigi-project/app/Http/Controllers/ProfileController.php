<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

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

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Debug logging
        Log::info('Profile update started', [
            'user_id' => $user->id,
            'has_file' => $request->hasFile('profile_image'),
            'remove_image' => $request->input('remove_image'),
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');

            // Debug file information
            Log::info('File upload details', [
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'temp_path' => $file->getPathname(),
                'is_valid' => $file->isValid(),
            ]);

            // Check if file is valid
            if (!$file->isValid()) {
                return Redirect::route('profile.edit')
                    ->with('error', 'Invalid file upload. Please try again.');
            }

            try {
                // Delete old image if exists
                if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                    Storage::disk('public')->delete($user->profile_image);
                    Log::info('Old profile image deleted', ['path' => $user->profile_image]);
                }

                // Generate unique filename
                $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();

                // Store new image using putFileAs for more control
                $imagePath = Storage::disk('public')->putFileAs(
                    'images/user_profiles',
                    $file,
                    $filename
                );

                // Verify file was stored
                if (!$imagePath || !Storage::disk('public')->exists($imagePath)) {
                    Log::error('File storage failed', ['attempted_path' => $imagePath]);
                    return Redirect::route('profile.edit')
                        ->with('error', 'Failed to save profile image. Please try again.');
                }

                Log::info('Profile image stored successfully', [
                    'path' => $imagePath,
                    'full_path' => Storage::disk('public')->path($imagePath),
                ]);

                // Set the profile image path on the user object
                $user->profile_image = $imagePath;
            } catch (\Exception $e) {
                Log::error('Profile image upload failed', [
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]);

                return Redirect::route('profile.edit')
                    ->with('error', 'Failed to upload profile image: ' . $e->getMessage());
            }
        }

        // Handle image removal
        if ($request->input('remove_image') == '1') {
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
                Log::info('Profile image removed', ['path' => $user->profile_image]);
            }
            $user->profile_image = null;
        }

        // Update other profile fields using the same $user object
        $validatedData = $request->validated();
        unset($validatedData['profile_image'], $validatedData['remove_image']);
        $user->fill($validatedData);

        // Handle email verification reset
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Save the user with all updates
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

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
