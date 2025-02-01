<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shift Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { margin-top: 20px; }
    </style>
</head>
<body>

    <h1 style="text-align: center;">Shift Report</h1>
    <p>Total Shifts: {{ $totalShifts }}</p>
    <p>Shifts Taken: {{ $takenShifts }}</p>
    <p>CaAs Not Picked: {{ $havenTPicked }}</p>

    @foreach($shifts as $shift)
            @if($shift->plottingans->count() > 0)  {{-- Skip if taken is 0 --}}
                <h3>ID #{{ $shift->id }} / 
                    Shift No. {{ $shift->shift_no }} / 
                    {{ \Carbon\Carbon::parse($shift->date)->format('l, d F Y') }} / 
                    {{ \Carbon\Carbon::parse($shift->time_start)->format('H:i') }} - 
                    {{ \Carbon\Carbon::parse($shift->time_end)->format('H:i') }} 
                    / Allocated: {{ $shift->plottingans->count() }}
                </h3>

                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Name</th>
                            <th>Major</th>
                            <th>Class</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shift->plottingans as $index => $plottingan)
                            @php $caas = $plottingan->caas; @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $caas->user->nim ?? '-' }}</td>
                                <td>{{ $caas->user->profile->name ?? 'N/A' }}</td>
                                <td>{{ $caas->user->profile->major ?? 'N/A' }}</td>
                                <td>{{ $caas->user->profile->class ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach


</body>
</html>
