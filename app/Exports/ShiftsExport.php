<?php

namespace App\Exports;

use App\Models\Shift;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ShiftsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Shift::select('shift_no', 'date', 'time_start', 'time_end', 'kuota')
                    ->withCount('plottingans')
                    ->get()
                    ->map(function ($shift) {
                        return [
                            'shift_no' => $shift->shift_no,
                            'date' => $shift->date,
                            'time' => $shift->time_start . ' - ' . $shift->time_end,
                            'quota' => $shift->kuota,
                            'taken' => $shift->plottingans_count,
                        ];
                    });
    }

    public function headings(): array
    {
        return ['Shift No', 'Date', 'Time', 'Quota', 'Taken'];
    }
}
