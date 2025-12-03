<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('profile.index')
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Handle upload profile picture
        if ($request->hasFile('profile_picture')) {
            // Hapus foto lama jika ada
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // Upload foto baru
            $file = $request->file('profile_picture');
            $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Simpan ke storage
            $path = $file->storeAs('profiles', $filename, 'public');

            $data['profile_picture'] = $path;
        }

        // Handle hapus profile picture
        if ($request->has('remove_picture') && $user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
            $data['profile_picture'] = null;
        }

        $user->update($data);

        return redirect()->route('profile.index')
            ->with('success', 'Profile berhasil diperbarui.');
    }

    public function showPasswordForm()
    {
        return view('profile.password');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('profile.password')
                ->withErrors($validator)
                ->withInput();
        }

        // Cek password saat ini
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('profile.password')
                ->with('error', 'Password saat ini salah.');
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('profile.password')
            ->with('success', 'Password berhasil diubah.');
    }

    // Method untuk menghapus profile picture
    public function deletePicture()
    {
        $user = Auth::user();

        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
            $user->update(['profile_picture' => null]);

            return redirect()->route('profile.index')
                ->with('success', 'Foto profile berhasil dihapus.');
        }

        return redirect()->route('profile.index')
            ->with('error', 'Tidak ada foto profile untuk dihapus.');
    }
}