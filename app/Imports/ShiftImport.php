<?php
// app/Imports/ShiftImport.php

namespace App\Imports;

use App\Models\Shift;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class ShiftImport implements ToModel, WithHeadingRow
{
    /**
     * Handle row data and import into the Shift model.
     */
    public function model(array $row)
    {
        // Validate required fields (skip row if missing `id`, `date`, or `shift_no`)
        if (empty($row['id']) || empty($row['shift_no']) || empty($row['date']) || empty($row['time_start']) || empty($row['time_end']) || empty($row['kuota'])) {
            return null; // Skip invalid row
        }

        try {
            return Shift::updateOrCreate(
                ['id' => $row['id']], // Use ID as the unique identifier
                [
                    'shift_no'   => $row['shift_no'],
                    'date'       => Carbon::parse($row['date'])->format('Y-m-d'),
                    'time_start' => Carbon::createFromFormat('H:i', $row['time_start'])->format('H:i:s'),
                    'time_end'   => Carbon::createFromFormat('H:i', $row['time_end'])->format('H:i:s'),
                    'kuota'      => (int) $row['kuota'],
                ]
            );
        } catch (\Exception $e) {
            return null; // Skip problematic row
        }
    }
}
