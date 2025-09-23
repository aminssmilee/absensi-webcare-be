<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user = $request->user();

        // Hapus foto lama jika ada
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        // Simpan foto baru
        $path = $request->file('photo')->store('profile_photos', 'public');
        $user->photo = $path;
        $user->save();

        return response()->json([
            'message' => 'Foto profil berhasil diunggah',
            'photo_url' => asset('storage/' . $path)
        ]);
    }

    public function removePhoto(Request $request)
    {
        $user = $request->user();

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
            $user->photo = null;
            $user->save();
        }

        return response()->json([
            'message' => 'Foto profil berhasil dihapus',
            'photo_url' => asset('img/user.png') // default
        ]);
    }
}
