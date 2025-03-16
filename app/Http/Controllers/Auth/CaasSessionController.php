<?php
// app/Http/Contollers/Auth/CaasSessionController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class CaasSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function index()
    {
        return view('CaAs.LoginCaAs'); // Blade CAAS login
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate(); // Akan memanggil rules() + authenticate()

        if ($request->user()->is_admin) { // admin jangan masuk lewat login caas ya
            $this->destroy($request);
        }

        $request->session()->regenerate();

        return redirect()->intended('/home'); // Setelah login -> /home
    }

/**
     * Proses ganti password CAAS.
     */
    public function updatePassword(Request $request)
    {
        // Validasi input
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8',
        ], [
            'old_password.required' => 'Old Password is required.',
            'new_password.required' => 'New Password is required.',
            'new_password.min' => 'New Password must be at least 8 characters.',
        ]);

        // Ambil user yang sedang login
        $user = Auth::user();

        // Cek apakah old_password sesuai
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Old password does not match our records.']);
        }

        // Update password ke database (dibungkus bcrypt)
        $user->update([
            'password' => bcrypt($request->new_password),
        ]);

        return back()->with('success', 'Password has been updated successfully.');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('caas.login'));
    }
}
