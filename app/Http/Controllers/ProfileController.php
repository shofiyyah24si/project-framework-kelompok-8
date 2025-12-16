<?php
// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $user = Auth::user();
        
        // Hapus avatar lama jika ada
        $this->deleteOldAvatar($user);
        
        // Generate unique filename
        $filename = 'avatar_' . $user->id . '_' . time() . '.' . $request->avatar->extension();
        $path = $request->avatar->storeAs('avatars', $filename, 'public');
        
        // Update user data
        $user->avatar = $filename;
        $user->avatar_updated_at = now();
        $user->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Foto profil berhasil diperbarui!',
            'avatar_url' => asset('storage/avatars/' . $filename)
        ]);
    }

    public function deleteAvatar()
    {
        $user = Auth::user();
        
        if ($user->avatar) {
            $this->deleteOldAvatar($user);
            
            $user->avatar = null;
            $user->avatar_updated_at = now();
            $user->save();
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Foto profil berhasil dihapus!',
            'avatar_url' => asset('images/default-avatar.png')
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;
        
        // Update password jika diisi
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password saat ini tidak valid!'
                ], 422);
            }
            $user->password = Hash::make($request->new_password);
        }
        
        $user->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui!'
        ]);
    }

    private function deleteOldAvatar($user)
    {
        if ($user->avatar && Storage::disk('public')->exists('avatars/' . $user->avatar)) {
            Storage::disk('public')->delete('avatars/' . $user->avatar);
        }
    }
}