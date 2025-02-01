<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    /**
     * Tampilkan form reset password admin.
     */
    public function showResetPasswordForm()
    {
        return view('admin.reset-password');
    }

    /**
     * Proses perubahan password admin.
     */
    public function updatePassword(Request $request)
    {
        // Validasi input
        $request->validate([
            'old_password' => 'required',
            'password'     => 'required|string|min:8|confirmed',
        ], [
            'password.confirmed' => 'New Password confirmation does not match.',
        ]);

        $user = Auth::user();

        // Cek old password apakah benar
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors([
                'old_password' => 'Old password is incorrect.',
            ]);
        }

        // Update password
        $user->password = bcrypt($request->password);
        $user->save(); // Eloquent => Metode 'save()' valid karena $user adalah instance model

        return redirect()->route('admin.reset-password')->with('status', 'Your password has been updated!');
    }
}
