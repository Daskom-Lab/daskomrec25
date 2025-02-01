<?php

// app/Exports/CaasExport.php

namespace App\Exports;

use App\Models\Caas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CaasExport implements FromCollection, WithHeadings
{
    /**
     * Retrieve data for the export.
     */
    public function collection()
    {
        return Caas::with(['user.profile', 'role', 'user.caasStage.stage'])
            ->get()
            ->map(function ($caas) {
                return [
                    'nim'      => $caas->user->nim ?? '',
                    'name'     => $caas->user->profile->name ?? '',
                    'email'    => $caas->user->profile->email ?? '',
                    'major'    => $caas->user->profile->major ?? '',
                    'gender'   => $caas->user->profile->gender ?? 'Unknown',
                    'class'    => $caas->user->profile->class ?? '',
                    'gems'     => $caas->role->name ?? 'No Gem',
                    'state'    => $caas->user->caasStage->stage->name ?? 'Unknown',
                    'status'   => $caas->user->caasStage->status ?? 'Unknown',
                ];
            });
    }

    /**
     * Set column headings for the export.
     */
    public function headings(): array
    {
        return [
            'NIM',
            'Name',
            'Email',
            'Major',
            'Gender',
            'Class',
            'Gems',
            'State',
            'Status',
        ];
    }
}
