<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shifts PDF</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h2>Shift Schedule</h2>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Shift No.</th>
                <th>Date</th>
                <th>Time</th>
                <th>Remaining Quota</th>
                <th>Taken</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shifts as $index => $shift)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $shift->shift_no }}</td>
                    <td>{{ $shift->date }}</td>
                    <td>{{ $shift->time_start }} - {{ $shift->time_end }}</td>
                    <td>{{ $shift->kuota }}</td>
                    <td>{{ $shift->plottingans_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
