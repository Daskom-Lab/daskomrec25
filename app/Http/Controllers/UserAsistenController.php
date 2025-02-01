<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAsistenController extends Controller
{
    public function index()
    {
        $users = User::with('profile')
            ->where('is_admin', 1)
            ->where('id', '!=', Auth::user()->id)
            ->get();

        $asistenList = $users->map(function ($user) {
            return [
                'id'            => $user->id,
                'kodeAsisten'   => $user->nim ?? '',
                'nama_lengkap'  => $user->profile->name ?? '',
                'divisi'        => $user->profile->major ?? '',
            ];
        });

        return view('admin.asisten', ['asistenList' => $asistenList]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kodeAsisten'  => 'required|string|max:12',
            'password'     => 'required|string|max:255',
            'nama_lengkap' => 'nullable|string|max:255',
            'divisi'       => 'nullable|string|max:255',
        ]);

        // Coba insert user
        try {
            $user = User::create([
                'nim'      => $validated['kodeAsisten'],
                'password' => bcrypt($validated['password']),
                'is_admin' => 1,
                'last_activity' => now()->getTimestamp(),
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // 409 = Conflict
            return response('Kode Asisten sudah terpakai.', 409);
        }

        $user->profile()->create([
            'name'  => $validated['nama_lengkap'] ?? '',
            'major' => $validated['divisi'] ?? '',
        ]);

        // Kembalikan JSON data user-nya
        return response()->json([
            'id'           => $user->id,
            'kodeAsisten'  => $user->nim,
            'nama_lengkap' => $validated['nama_lengkap'] ?? '',
            'divisi'       => $validated['divisi'] ?? '',
        ], 201);
    }

    public function update(Request $request, $id)
    {
        // Jika "setPass" -> ganti password
        if ($request->has('setPass')) {
            if ($request->filled('setPass')) {
                $validated = $request->validate([
                    'setPass' => 'required|string|max:255'
                ]);

                $user = User::findOrFail($id);
                $user->update(['password' => bcrypt($validated['setPass'])]);

                return response('Password updated successfully', 200);
            } else {
                return response('Password cannot be empty.', 422);
            }
        }

        // Update data
        $validated = $request->validate([
            'kodeAsisten'  => 'required|string|max:12',
            'nama_lengkap' => 'nullable|string|max:255',
            'divisi'       => 'nullable|string|max:255',
        ]);

        $user = User::with('profile')->findOrFail($id);

        try {
            $user->update([
                'nim' => $validated['kodeAsisten']
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response('That kodeAsisten cannot be used.', 409);
        }

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'name'  => $validated['nama_lengkap'] ?? '',
                'major' => $validated['divisi'] ?? '',
            ]
        );

        return response('Asisten updated', 200);
    }

    public function destroy($id)
    {
        User::destroy($id);
        return response('Asisten deleted', 200);
    }
    
}
