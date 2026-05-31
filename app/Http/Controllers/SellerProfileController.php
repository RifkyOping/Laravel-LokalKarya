<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\SellerProfile;

class SellerProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('seller.profile', [
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

        return Redirect::route('profile.seller')->with('status', 'profile-updated');
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

    public function updateWhatsapp(Request $request): RedirectResponse
    {
        $request->validate([
            'nomor_whatsapp' => ['required', 'string', 'max:15', 'regex:/^62/'],
        ], [
            'nomor_whatsapp.regex' => 'Nomor WhatsApp harus diawali dengan kode negara 62 (contoh: 6281234567890).',
        ]);

        $user = $request->user();

        SellerProfile::updateOrCreate(
            ['user_id' => $user->id], 
            [
                'nomor_whatsapp' => $request->nomor_whatsapp
            ]
        );

        return Redirect::route('profile.seller')->with('status', 'whatsapp-updated');
    }

    public function updateDetails(Request $request): RedirectResponse
    {
        $request->validate([
            'bidang_keahlian' => ['nullable', 'string', 'max:255'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'tentang_saya' => ['nullable', 'string', 'max:1000'],
        ]);

        $user = $request->user();

        SellerProfile::updateOrCreate(
            ['user_id' => $user->id], 
            [
                'bidang_keahlian' => $request->bidang_keahlian,
                'alamat' => $request->alamat,
                'deskripsi' => $request->tentang_saya
            ]
        );

        return Redirect::route('profile.seller')->with('status', 'details-updated');
    }

    public function updatePhoto(Request $request): RedirectResponse
    {
        $request->validate([
            'foto' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $user = $request->user();
        $profile = SellerProfile::firstOrCreate(['user_id' => $user->id]);

        if ($request->hasFile('foto')) {
            if ($profile->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($profile->foto)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($profile->foto);
            }

            $path = $request->file('foto')->store('profiles', 'public');
            $profile->foto = $path;
            $profile->save();
        }

        return Redirect::route('profile.seller')->with('status', 'photo-updated');
    }

    public function addPortfolio(Request $request): RedirectResponse
    {
        $request->validate([
            'judul_karya' => ['required', 'string', 'max:255'],
            'link_karya' => ['required', 'url', 'max:2048'],
        ]);

        $user = $request->user();
        $profile = SellerProfile::firstOrCreate(['user_id' => $user->id]);

        $currentPortfolio = $profile->link_portofolio ?? [];
        if (count($currentPortfolio) >= 10) {
            return back()->withErrors(['link_karya' => 'Maksimal 10 link portfolio yang diizinkan.']);
        }

        $portfolio = $profile->link_portofolio ?? [];
        $portfolio[] = [
            'judul' => $request->judul_karya,
            'link' => $request->link_karya,
        ];

        $profile->link_portofolio = $portfolio;
        $profile->save();

        return Redirect::route('profile.seller')->with('status', 'portfolio-added');
    }

    public function deletePortfolio(Request $request, $index): RedirectResponse
    {
        $user = $request->user();
        $profile = $user->sellerProfile;

        if ($profile && isset($profile->link_portofolio[$index])) {
            $portfolio = $profile->link_portofolio;
            unset($portfolio[$index]);
            $profile->link_portofolio = array_values($portfolio);
            $profile->save();
        }

        return Redirect::route('profile.seller')->with('status', 'portfolio-deleted');
    }
}