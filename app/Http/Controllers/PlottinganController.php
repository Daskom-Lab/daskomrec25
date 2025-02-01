<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plottingan;
use App\Models\Shift;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Caas;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ShiftsExport;
use Maatwebsite\Excel\Facades\Excel;

class PlottinganController extends Controller
{
    /**
     * Tampilkan halaman daftar SHIFT untuk CAAS (choose-shift).
     * Jika kebijakan hanya boleh pilih 1 SHIFT total:
     *   - Jika CAAS sudah punya SHIFT, redirect ke fixShiftView.
     */
    public function chooseShiftView()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login')->with('error', 'Please login first');
        }

        $caas = Caas::where('user_id', $user->id)->first();
        if (!$caas) {
            return redirect('/login')->with('error', 'Something is wrong with your CAAS data');
        }

        // If user is fail, just redirect them
        if ($user->caasStage && $user->caasStage->status === 'Fail') {
            return redirect()->route('caas.home')
                ->with('error', 'You cannot choose a shift because you have failed.');
        }

        // Cek apakah user sudah memiliki SHIFT (jika kebijakan 1 SHIFT total)
        //   -> Jika boleh multiple SHIFT non-overlap, bisa dihapus logic ini
        $alreadyHasShift = Plottingan::where('caas_id', $caas->id)->exists();
        if ($alreadyHasShift) {
            return redirect()->route('caas.fix-shift')->with('error', 'Already picked!');
        }

        // Ambil daftar SHIFT (bisa pakai filter SHIFT yg masih ada sisa kuota > 0)
        $shifts = Shift::orderBy('date', 'asc')
            ->orderBy('time_start', 'asc')
            ->get();
        $shifts = Shift::withCount('plottingans')->get();

        // Return ke blade "CaAs.ChooseShift"
        return view('CaAs.ChooseShift', compact('shifts'));
    }

    public function pickShift(Request $request)
    {
        $request->validate([
            'shift_id' => 'required|exists:shifts,id',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect('/login')->with('error', 'Not authenticated');
        }

        $caas = Caas::where('user_id', $user->id)->first();
        if (!$caas) {
            return redirect()->back()->with('error', 'No CAAS record found');
        }

        // Jika kebijakan: CAAS hanya boleh 1 SHIFT total
        $existingPlot = Plottingan::where('caas_id', $caas->id)->first();
        if ($existingPlot) {
            return redirect()->back()->with('error', 'You already picked a shift!');
        }

        // DB::transaction + lock SHIFT agar aman
        try {
            DB::transaction(function () use ($request, $caas) {
                // Lock SHIFT row
                $shift = Shift::where('id', $request->shift_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                // 1) Cek kuota SHIFT
                $alreadyPickedCount = Plottingan::where('shift_id', $shift->id)->count();
                if ($alreadyPickedCount >= $shift->kuota) {
                    throw new \Exception('Shift is full. Quota exceeded! Please reload the page.');
                }

                // 2) Cek overlap SHIFT di hari yang sama
                //    -> Hanya relevan jika CAAS boleh ambil banyak SHIFT asalkan tidak overlap
                //    -> Jika kebijakan 1 SHIFT total, bagian ini opsional
                $isOverlap = Plottingan::join('shifts', 'plottingans.shift_id', '=', 'shifts.id')
                    ->where('plottingans.caas_id', $caas->id)
                    ->whereDate('shifts.date', $shift->date)
                    ->where(function ($query) use ($shift) {
                        $query->whereBetween('shifts.time_start', [$shift->time_start, $shift->time_end])
                            ->orWhereBetween('shifts.time_end',   [$shift->time_start, $shift->time_end]);
                    })
                    ->exists();

                if ($isOverlap) {
                    throw new \Exception('You already picked a shift that overlaps with this time!');
                }

                // 3) Simpan Plottingan
                Plottingan::create([
                    'caas_id'  => $caas->id,
                    'shift_id' => $shift->id,
                ]);
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect('/shift')->with('success', 'Shift picked successfully!');
    }

    /**
     * Tampilkan SHIFT yang sudah diambil (fixShiftView).
     * Mirip fixGemView. Jika belum ambil SHIFT, redirect ke chooseShift.
     */
    public function fixShiftView()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login')->with('error', 'Please login first');
        }

        $caas = Caas::where('user_id', $user->id)->first();
        if (!$caas) {
            return redirect('/login')->with('error', 'No CAAS record found');
        }

        // Ambil SHIFT user. Jika kebijakan 1 SHIFT total, user hanya punya 1 SHIFT
        $plot = Plottingan::with('shift')
            ->where('caas_id', $caas->id)
            ->first();

        if (!$plot || !$plot->shift) {
            return redirect()->route('caas.choose-shift')->with('error', 'Pick a shift first!');
        }

        // Tampilkan SHIFT di Blade "CaAs.FixShift"
        $shift = $plot->shift;
        return view('CaAs.FixShift', compact('shift'));
    }

    // ================ VIEW PLOT (Halaman Admin) ================
    public function viewPlot()
    {
        // Menampilkan ringkasan SHIFT dan total CAAS yang mengambil
        // SHIFT::withCount('plottingans') -> agar dapat plottingans_count
        $shifts = Shift::withCount('plottingans')
            ->orderBy('date', 'asc')
            ->orderBy('time_start', 'asc')
            ->get();

        $totalShifts = $shifts->count();
        $takenShifts = $shifts->sum('plottingans_count');

        $totalCaas    = Caas::count();
        $havenTPicked = $totalCaas - $takenShifts;
        // definisi "haven't picked" menyesuaikan aturan

        return view('admin.view-plot', compact('shifts', 'totalShifts', 'takenShifts', 'havenTPicked'));
    }

    // ================ DETAIL SHIFT ================
    public function show($id)
    {
        // Lihat SHIFT + siapa saja yang pick SHIFT ini
        // plottingans.caas => agar data CAAS juga ke-load
        $shift = Shift::with([
            'plottingans.caas.user.profile',  // Loads user profile data
            'plottingans.caas.user.caasStage.stage', // Loads caasStage and stage details
            'plottingans.caas.role' // Loads the role (gems)
        ])->findOrFail($id);
        // Di atas: 
        //   - "caas.user.profile" => kalau CAAS punya user_id => user => profile
        //     Sesuaikan relasi di model CAAS.
        return view('admin.view-plot-show', compact('shift'));
    }

    public function exportPdf()
    {
        $shiftsC = Shift::withCount('plottingans')->get();
        $totalShifts = $shiftsC->count();
        $takenShifts = $shiftsC->sum('plottingans_count');
        $totalCaas    = Caas::count();
        $havenTPicked = $totalCaas - $takenShifts;

        $shifts = Shift::with(['plottingans.caas.user.profile'])->get();

        $pdf = Pdf::loadView('admin.plots-pdf', compact('shifts', 'totalShifts', 'takenShifts', 'havenTPicked'));

        return $pdf->download('shifts_report.pdf');
    }
}
