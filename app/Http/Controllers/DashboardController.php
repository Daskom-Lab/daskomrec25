<?php
// app/Http/Contollers/DashboardController.php

namespace App\Http\Controllers;

use App\Enums\StageEnum;
use App\Models\Configuration;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stage = Stage::firstOrCreate(
            ['id' => 1], 
            ['name'=>StageEnum::Administration->value]
        );
        $record = Configuration::firstOrCreate(
            ['id' => 1],
            [
                'pengumuman_on' => false,
                'isi_jadwal_on' => false,
                'role_on' => false,
                'current_stage_id' => $stage->id,
            ]
        );
    
        $data = [
            'announcement' => $record->pengumuman_on,
            'shift' => $record->isi_jadwal_on,
            'gems' => $record->role_on,
            'current_state' => Stage::find($record->current_stage_id)->name,
        ];
        return view('admin.dashboard', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->index();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'pengumuman_on' => 'required|bool',
            'isi_jadwal_on' => 'required|bool',
            'role_on' => 'required|bool',
            'current_stage' => ['required', new Enum(StageEnum::class)],
        ]);
        
        $stage = Stage::firstOrCreate(
            ['name' => $validated['current_stage']]
        );

        Configuration::find(1)->update([
            'pengumuman_on' => $validated['pengumuman_on'],
            'isi_jadwal_on' => $validated['isi_jadwal_on'],
            'role_on' => $validated['role_on'],
            'current_stage_id' => $stage->id,
        ]);
        
        return response()->json(['success' => 'Successfully updated configuration'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->index();
    }
}
