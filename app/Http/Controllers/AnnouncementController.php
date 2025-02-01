<?php
// app/Http/Contollers/AnnouncementController.php
namespace App\Http\Controllers;

use App\Enums\StageEnum;
use App\Models\Announcement;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AnnouncementController extends Controller
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
        
        $record = Announcement::firstOrCreate(
            ['id' => 1],
            [
                'success_message' => 'Kamu lolos tahap ini',
                'fail_message' => 'Maaf kamu gagal',
                'stage_id' => $stage->id,
            ]
        );
        
        $lastUpdated = $record->updated_at;

        $data = [
            'pass' => $record->success_message,
            'fail' => $record->fail_message,
            'link' => $record->link,
            'lastUpdated' => $lastUpdated ? $lastUpdated->timestamp : null,
        ];
        
        return view('admin.announcement', $data);
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
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'success_message' => 'required|string',
            'fail_message' => 'required|string',
            'link' => 'nullable|string|max:255',
            'stage_id' => 'required|int',
        ]);
        Announcement::find(1)->update($validated);
        return redirect()->route('admin.announcement');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->index();
    }
}
