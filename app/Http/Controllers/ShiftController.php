<?php

namespace App\Http\Controllers;

use App\Exports\ShiftsExport;
use App\Http\Controllers\Controller;
use App\Imports\ShiftImport;
use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\Plottingan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ShiftController extends Controller
{
    /**
     * Tampilkan list SHIFT (untuk admin).
     */
    public function index()
    {
        // Ambil semua shift
        $shifts = Shift::orderBy('date', 'asc')
                       ->orderBy('time_start', 'asc')
                       ->get();

        // Return ke Blade 'admin.shift'
        return view('admin.shift', compact('shifts'));
    }

    /**
     * Simpan SHIFT baru (Add Shift).
     */
    public function store(Request $request)
    {
        $request->validate([
            'shift_no'   => 'required|string|max:50',
            'date'       => 'required|date',
            'time_start' => 'required',
            'time_end'   => 'required',
            'kuota'      => 'required|integer|min:0',
        ]);

        Shift::create([
            'shift_no'   => $request->shift_no,
            'date'       => $request->date,
            'time_start' => $request->time_start,
            'time_end'   => $request->time_end,
            'kuota'      => $request->kuota,
        ]);

        return redirect()->back()->with('success', 'Shift created successfully!');
    }

    /**
     * Menampilkan detail SHIFT tertentu (opsional).
     */
    public function show($id)
    {
        $shift = Shift::findOrFail($id);
        return view('admin.shift-show', compact('shift'));
    }

    /**
     * Update SHIFT (Edit Shift).
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'shift_no'   => 'required|string|max:50',
            'date'       => 'required|date',
            'time_start' => 'required',
            'time_end'   => 'required',
            'kuota'      => 'required|integer|min:0',
        ]);

        $shift = Shift::findOrFail($id);
        $shift->update([
            'shift_no'   => $request->shift_no,
            'date'       => $request->date,
            'time_start' => $request->time_start,
            'time_end'   => $request->time_end,
            'kuota'      => $request->kuota,
        ]);

        return redirect()->back()->with('success', 'Shift updated successfully!');
    }

    /**
     * Hapus SHIFT (Delete).
     */
    public function destroy($id)
    {
        $shift = Shift::findOrFail($id);
        // Opsi: Hapus Plottingan milik SHIFT ini jg
        // Plottingan::where('shift_id',$id)->delete();
        $shift->delete();

        return redirect()->back()->with('success', 'Shift deleted successfully!');
    }

    /**
     * RESET SHIFT: hapus semua SHIFT (dan Plottingan jika diperlukan).
     */
    public function resetShifts()
{
    DB::transaction(function() {
        // 1. Hapus semua di plottingans
        Plottingan::query()->delete();

        // 2. Hapus semua di shifts
        Shift::query()->delete();
    });

    return redirect()->back()->with('success', 'All Shifts have been reset!');
}

    /**
     * RESET PLOT: hapus semua data Plottingan.
     */
    public function resetPlot()
    {
        Plottingan::truncate();
        return redirect()->back()->with('success', 'All Plots have been reset!');
    }

    public function exportPdf()
    {
        $shifts = Shift::withCount('plottingans')->get();

        $pdf = Pdf::loadView('admin.shifts-pdf', compact('shifts'));
        return $pdf->download('shifts.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ShiftsExport, 'shifts.xlsx');
    }

    public function importShift(Request $request)
    {
        // Validate file input
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls|max:2048',
        ]);

        try {
            Excel::import(new ShiftImport, $request->file('file'));

            return back()->with('success', 'Shifts imported successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error importing shifts: ' . $e->getMessage());
        }
    }
}
