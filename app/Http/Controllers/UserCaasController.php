<?php
// app/Http/Contollers/UserCaasController.php

namespace App\Http\Controllers;

use App\Exports\CaasExport;
use App\Imports\CaasImport;
use App\Models\Caas;
use App\Models\Role;
use App\Models\Stage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class UserCaasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userCount = User::where('is_admin', 0)->count();
        $caasCount = Caas::count();

        if ($caasCount !== $userCount) { // in case Caas is empty somehow???
            $users = User::with(['profile', 'caasStage', 'caas'])->where('is_admin', 0)->get();
            foreach ($users as $user) {
                // Skip users who already have a Caas record
                if ($user->caas) {
                    continue;
                }

                // Create the Caas record
                Caas::create([
                    'user_id' => $user->id,
                    'role_id' => null,
                ]);
            }
        }
        // Fetch all Caas with their related User, Profile, and Role
        $caas = Caas::with(['user.profile', 'user.caasStage', 'role'])->get();
        // Map data to match the desired structure
        $caasList = $caas->map(function ($caas) {
            return [
                'id' => $caas->id,
                'nim' => $caas->user->nim ?? '',
                'name' => $caas->user->profile->name ?? '',
                'email' => $caas->user->profile->email ?? '',
                'major' => $caas->user->profile->major ?? '',
                'gender' => $caas->user->profile->gender ?? 'Unknown',
                'className' => $caas->user->profile->class ?? '',
                'gems' => $caas->role->name ?? 'No Gem',
                'state' => $caas->user->caasStage->stage->name ?? 'Unknown',
                'status' => $caas->user->caasStage->status ?? 'Unknown',
                'lastActivity' => $caas->user->last_activity,
                'lastSeenAnnouncement' => $caas->user->last_seen_announcement,
            ];
        });

        // Pass the data to the view
        return view('admin.caas', ['caasList' => $caasList]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|string|max:12',
            'password' => 'required|string|max:255',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:10',
            'className' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
        ]);

        try {
            $user = User::create([
                'nim' => $validated['nim'],
                'password' => bcrypt($validated['password']),
                'last_activity' => now()->getTimestamp(),
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => 'That NIM already exists.'], 409);
        }

        $user->profile()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'major' => $validated['major'],
            'class' => $validated['className'],
            'gender' => $validated['gender'],
        ]);

        Caas::create([
            'user_id' => $user->id,
            'role_id' => null, // Cukup set role_id = null => menandakan "belum memilih gem"
        ]);

        // Jika user tidak mengirim state -> fallback "Administration"
        $stageName = $validated['state'] ?? 'Administration';
        $stage = Stage::firstOrCreate(['name' => $stageName]);

        // Default status => "Unknown"
        $user->caasStage()->create([
            'stage_id' => $stage->id,
            'status'   => 'Unknown',
        ]);

        return response()->json(['success' => 'Successfully created new CaAs'], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->has('setPass')) {
            if ($request->filled('setPass')) {
                $validated = $request->validate([
                    'setPass' => 'required|string|max:255'
                ]);

                $caas = Caas::with(['user'])->findOrFail($id);
                $caas->user->update([
                    'password' => bcrypt($validated['setPass']),
                ]);

                return response()->json(['message' => 'Password updated successfully.'], 200);
            } else {
                // Handle the case where 'set_pass' is empty
                return response()->json(['error' => 'Password cannot be empty.'], 422);
            }
        }

        $validated = $request->validate([
            // 'nim' => 'required|string|max:12', // kan gak bisa edit nim di frontend admin
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
            'className' => 'nullable|string|max:255',
            'gems' => 'nullable|string|max:255',  // "No Gem" atau nama gem
            'gender' => 'nullable|string|max:10',
            'status' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
        ]);

        $caas = Caas::with(['user.profile', 'role', 'user.caasStage'])->findOrFail($id);

        // $caas->user->update([
        //     'nim' => $validated['nim'],
        // ]);

        $caas->user->profile()->updateOrCreate(
            ['user_id' => $caas->user->id],
            [
                'name' => $validated['name'],
                'major' => $validated['major'],
                'class' => $validated['className'],
                'email' => $validated['email'],
                'gender' => $validated['gender'],
            ]
        );

        // Jika admin memasukkan "No Gems", maka role_id = null
        if (isset($validated['gems']) && strtolower($validated['gems']) === 'no gem') {
            $caas->role_id = null;
            $caas->save();
        } 
        // Jika admin memasukkan nama gem, kita cari/buat role di DB
        elseif (!empty($validated['gems'])) {
            $role = Role::firstOrCreate(['name' => $validated['gems']]);
            $caas->role_id = $role->id;
            $caas->save();
        }

        $stage = Stage::firstOrCreate(
            ['name' => $validated['state']], // Search condition
            ['name' => $validated['state']] // Values to insert if not found
        );

        $caas->user->caasStage()->updateOrCreate(
            ['user_id' => $caas->user->id],
            [
                'status' => $validated['status'],
                'stage_id' => $stage->id,
            ]
        );

        return response()->json(['success' => 'Successfully updated CaAs'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $caas = Caas::findOrFail($id);
        User::destroy($caas->user_id);
        return response()->json(['success' => 'Deleted'], 200);
    }

    public function importCaas(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        Excel::import(new CaasImport, $request->file('file'));

        return response()->json(['success' => 'Successfully imported data'], 200);
    }

    public function exportCaas()
    {
        return Excel::download(new CaasExport, 'caas_list.xlsx');
    }

    public function chooseGemView()
    {
        // Pastikan user login
        $user = Auth::user();
        if (!$user) {
            return redirect('/login')->with('error', 'You must be logged in.');
        }

        // Cek apakah user sudah punya record Caas
        $caas = Caas::where('user_id', $user->id)->first();

        // Jika user sudah memilih gem, langsung redirect ke fixGemView
        if ($caas && $caas->role_id) {
            return redirect()->route('caas.fix-gem')
                ->with('error', 'You have already chosen a gem!');
        }

        // Ambil semua gems
        $gems = Role::select('id', 'name', 'description', 'image', 'quota')
            ->orderBy('name')
            ->get();

        // Tampilkan ke Blade "CaAs.ChooseGem"
        return view('CaAs.ChooseGem', [
            'gems'      => $gems,
            'userGemId' => $caas?->role_id,  // null jika belum memilih
        ]);
    }

    /**
     * Handle the CAAS user picking a gem.
     */
    public function pickGem(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }

        // Get / buat record Caas
        $caas = Caas::where('user_id', $user->id)->first();
        if (!$caas) {
            $caas = Caas::create([
                'user_id' => $user->id,
                'role_id' => null,
            ]);
        }

        // Cek apakah user sudah pernah memilih gem
        if (!is_null($caas->role_id)) {
            return response()->json([
                'error' => 'You have already chosen a gem. It cannot be changed!'
            ], 409);
        }

        // DB transaction + lock agar quota tidak bentrok
        try {
            DB::transaction(function () use ($caas, $request) {
                $role = Role::where('id', $request->role_id)
                    ->lockForUpdate()
                    ->first(); // or findOrFail

                // Cek quota
                if ($role->quota < 1) {
                    throw new \Exception("Gem is out of quota!, kemungkinan ada orang yang bersamaan dengan kamu milihnya, tapi dia duluan. Reload lagi ya");
                }

                // Assign gem
                $caas->role_id = $role->id;
                $caas->save();

                // Decrement gem's quota
                $role->quota = $role->quota - 1;
                $role->save();
            });
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 409);
        }

        return response()->json([
            'success' => true,
            'message' => 'Gem chosen successfully!',
        ]);
    }

    /**
     * Tampilkan konfirmasi gem yang sudah dipilih (FixGem).
     */
    public function fixGemView()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login')->with('error', 'Please login first');
        }

        $caas = Caas::where('user_id', $user->id)->with('role')->first();
        if (!$caas || !$caas->role) {
            // Kalau belum pilih gem, redirect ke pemilihan
            return redirect('/choose-gem')->with('error', 'Please choose a gem first');
        }

        $gem = $caas->role;
        return view('CaAs.FixGem', compact('gem'));
    }
}
