<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Geef een openbare profielpagina weer op basis van gebruikersnaam.
     */
    public function show($username): View
    {
        $profile = Profile::where('username', $username)->firstOrFail();
        if (!$profile) {
        abort(404, 'Profiel niet gevonden');
    }
        return view('profiles.show', compact('profile'));
    }

    /**
     * Toon de edit form voor de user
     */
    public function edit(Request $request): View
{
    $user = $request->user();
    if (!$user->profile) {
        $user->profile()->create(['user_id' => $user->id]);
    }
    return view('profiles.edit', [
        'user' => $user,
        'profile' => $user->profile,
    ]);
}

    /**
     * Bewerkt user profiel info
     */
    public function update(Request $request): RedirectResponse
    {
        $profile = $request->user()->profile;

        $request->validate([
            'username' => 'nullable|string|max:255|unique:profiles,username,' . $profile->id,
            'birthday' => 'nullable|date',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'about_me' => 'nullable|string|max:500',
            'name' => 'required|string|max:255', // 
            'email' => 'required|string|email|max:255|unique:users,email,' . $request->user()->id,
        ]);

        // Bewerkt User model (Breeze fields)
        $request->user()->fill([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // Bewerkt Profiel
        if ($request->hasFile('profile_picture')) {
            if ($profile->profile_picture) {
                Storage::disk('public')->delete($profile->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $profile->profile_picture = $path;
        }

        $profile->username = $request->username;
        $profile->birthday = $request->birthday;
        $profile->about_me = $request->about_me;
        $profile->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Verwijder User account.
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