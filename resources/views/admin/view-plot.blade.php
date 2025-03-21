<!-- resources/views/admin/view-plot.blade.php -->
@extends('admin.layouts.app')

@section('title', 'View Plot - Crystal Cavern')

@section('content')
<div 
    class="relative min-h-screen w-full max-w-screen-2xl mx-auto px-4 sm:px-6 md:px-8 py-6"
>
    <!-- HEADER: Judul & Tombol Back -->
    <div 
        class="mb-8 flex flex-col gap-4 items-center 
               sm:flex-row sm:justify-between sm:items-center"
    >
        <!-- Judul Halaman -->
        <h1 
            class="text-3xl sm:text-4xl md:text-5xl font-im-fell-english
                   text-white text-center sm:text-left"
        >
            View Plots
        </h1>

        <!-- Tombol Back -->
        <div>
            <a 
                href="{{ route('admin.shift') }}"
                class="bg-biru-tua text-white rounded-[30px] 
                       px-4 py-3 sm:px-6 sm:py-4 
                       hover:opacity-90 hover:shadow-lg transition
                       text-lg sm:text-2xl font-im-fell-english"
            >
                Back
            </a>
        </div>
    </div>

    <!-- STATISTIC CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <!-- Card: Total Shifts -->
        <div class="bg-custom-gray rounded-[30px] p-6 flex flex-col items-center shadow-md">
            <p class="text-biru-tua text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2">
                Total Shifts
            </p>
            <p class="text-biru-tua text-5xl sm:text-6xl md:text-7xl font-im-fell-english leading-tight">
                {{ $totalShifts }}
            </p>
        </div>
        <!-- Card: Taken Shifts -->
        <div class="bg-custom-gray rounded-[30px] p-6 flex flex-col items-center shadow-md">
            <p class="text-biru-tua text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2 text-center">
                Taken Shifts
            </p>
            <p class="text-biru-tua text-5xl sm:text-6xl md:text-7xl font-im-fell-english leading-tight">
                {{ $takenShifts }}
            </p>
        </div>
        <!-- Card: Haven't Picked -->
        <div class="bg-biru-tua rounded-[30px] p-6 flex flex-col items-center shadow-md">
            <p class="text-white text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2">
                <a href="{{ route('admin.plot.havenpicked') }}" class="hover:underline">
                    Haven't Picked
                </a>
            </p>
            <p class="text-white text-5xl sm:text-6xl md:text-7xl font-im-fell-english leading-tight">
                <a href="{{ route('admin.plot.havenpicked') }}" class="hover:underline">
                    {{ $havenTPicked }}
                </a>
            </p>
        </div>        
    </div>

    <!-- TABEL PLOT SHIFT -->
    <div class="bg-custom-gray rounded-[30px] p-6 sm:p-8 shadow-lg" id="plotTableContainer">
        <!-- Search & Export Buttons -->
        <div 
            class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-3"
        >
            <!-- Opsi-opsi -->
            <div class="flex flex-wrap items-center gap-2">
                <!-- SEARCH -->
                <div class="flex items-center space-x-2">
                    <label 
                        for="searchInput" 
                        class="text-biru-tua text-base sm:text-lg md:text-xl font-im-fell-english"
                    >
                        Search
                    </label>
                    <input 
                        type="text" 
                        id="searchInput"
                        class="bg-white border border-biru-tua rounded-[30px] px-3 py-1 
                               focus:outline-none focus:ring-1 focus:ring-biru-tua
                               text-sm sm:text-base"
                        placeholder="Search shift..."
                    >
                </div>
                <a href="{{ route('admin.shift.export.excel') }}" class="bg-biru-tua text-white px-4 py-1 rounded-[30px] hover:opacity-90 transition text-sm">
                    Shift Excel
                </a>
                <a href="{{ route('admin.shift.export.pdf') }}" class="bg-biru-tua text-white px-4 py-1 rounded-[30px] hover:opacity-90 transition text-sm">
                    Shift PDF
                </a>
                <a href="{{ route('admin.plot.export.pdf') }}" class="bg-biru-tua text-white px-4 py-1 rounded-[30px] hover:opacity-90 transition text-sm">
                    Plot PDF
                </a>
            </div>

            <!-- Bagian Sorting -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                <!-- SORT: Pilih kolom + asc/desc -->
                <div class="flex items-center space-x-2">
                    <label 
                        for="sortColumn"
                        class="text-biru-tua text-base sm:text-lg md:text-xl font-im-fell-english"
                    >
                        Sort By
                    </label>
                    <select 
                        id="sortColumn"
                        class="bg-white border border-biru-tua rounded-[30px] px-3 py-1 text-sm sm:text-base"
                    >
                        <option value="">No Sorting</option>
                        <option value="date">Date</option>
                        <option value="time">Time</option>
                        <option value="remainingQuota">Remaining Quota</option>
                        <option value="taken">Taken</option>
                    </select>
                    <select 
                        id="sortOrder"
                        class="bg-white border border-biru-tua rounded-[30px] px-3 py-1 text-sm sm:text-base"
                    >
                        <option value="asc" selected>Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full border border-black rounded-md overflow-hidden table-auto">
                <thead class="bg-white">
                    <tr class="border-b border-black">
                        <th 
                            class="py-3 px-3 border-r border-black text-biru-tua
                                   font-im-fell-english text-sm sm:text-base md:text-lg text-center"
                        >
                            No.
                        </th>
                        <th 
                            class="py-3 px-3 border-r border-black text-biru-tua
                                   font-im-fell-english text-sm sm:text-base md:text-lg text-center"
                        >
                            Shift
                        </th>
                        <th 
                            class="py-3 px-3 border-r border-black text-biru-tua
                                   font-im-fell-english text-sm sm:text-base md:text-lg text-center"
                        >
                            Date
                        </th>
                        <th 
                            class="py-3 px-3 border-r border-black text-biru-tua
                                   font-im-fell-english text-sm sm:text-base md:text-lg text-center"
                        >
                            Time
                        </th>
                        <th 
                            class="py-3 px-3 border-r border-black text-biru-tua
                                   font-im-fell-english text-sm sm:text-base md:text-lg text-center"
                        >
                            Remaining Quota
                        </th>
                        <th 
                            class="py-3 px-3 border-r border-black text-biru-tua
                                   font-im-fell-english text-sm sm:text-base md:text-lg text-center"
                        >
                            Taken
                        </th>
                        <th 
                            class="py-3 px-3 text-biru-tua
                                   font-im-fell-english text-sm sm:text-base md:text-lg text-center"
                        >
                            Detail
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white" id="plotTableBody">
                    @foreach($shifts as $index => $shift)
                        <tr class="border-b border-black last:border-b-0">
                            <!-- No. -->
                            <td 
                                class="py-3 px-3 border-r border-black text-biru-tua
                                       font-im-fell-english text-sm sm:text-base text-center"
                            >
                                {{ $index + 1 }}.
                            </td>
                            <!-- Shift No. -->
                            <td 
                                class="py-3 px-3 border-r border-black text-biru-tua
                                       font-im-fell-english text-sm sm:text-base text-center"
                            >
                                {{ $shift->shift_no }}
                            </td>
                            <!-- Date -->
                            <td 
                                class="py-3 px-3 border-r border-black text-biru-tua
                                       font-im-fell-english text-sm sm:text-base text-center"
                            >
                                {{ $shift->date }}
                            </td>
                            <!-- Time -->
                            <td 
                                class="py-3 px-3 border-r border-black text-biru-tua
                                       font-im-fell-english text-sm sm:text-base text-center"
                            >
                                {{ substr($shift->time_start, 0, 5) }} - {{ substr($shift->time_end, 0, 5) }}
                            </td>
                            <!-- Remaining Quota -->
                            <td 
                                class="py-3 px-3 border-r border-black text-biru-tua
                                       font-im-fell-english text-sm sm:text-base text-center"
                            >
                                {{ $shift->kuota - $shift->plottingans_count }}
                            </td>
                            <!-- Taken (jumlah CAAS) -->
                            <td 
                                class="py-3 px-3 border-r border-black text-biru-tua
                                       font-im-fell-english text-sm sm:text-base text-center"
                            >
                                {{ $shift->plottingans_count }}
                            </td>
                            <!-- Detail (lihat daftar CAAS) -->
                            <td 
                                class="py-3 px-3 text-biru-tua
                                       font-im-fell-english text-sm sm:text-base text-center"
                            >
                                <a 
                                    href="{{ route('admin.view-plot.show', $shift->id) }}"
                                    class="bg-biru-tua text-white px-3 py-1 rounded-[15px] 
                                           hover:opacity-90 hover:shadow-md transition text-sm"
                                >
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Script Search & Sort (Client Side) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.querySelector('#plotTableBody');
    // Ambil semua baris tr di dalam tbody
    let rows = Array.from(tableBody.querySelectorAll('tr')).map((tr) => {
        const td = tr.querySelectorAll('td');
        return {
            element: tr,
            // Kolom: 
            // td[1] => Shift No
            // td[2] => Date
            // td[3] => Time
            // td[4] => Remaining Quota
            // td[5] => Taken
            // Catatan: td[0] adalah "No."
            shiftNo: td[1].innerText.trim().toLowerCase(),
            date: td[2].innerText.trim().toLowerCase(),
            time: td[3].innerText.trim().toLowerCase(),
            remainingQuota: td[4].innerText.trim().toLowerCase(),
            taken: td[5].innerText.trim().toLowerCase(),
        };
    });

    const searchInput = document.getElementById('searchInput');
    const sortColumnSelect = document.getElementById('sortColumn');
    const sortOrderSelect = document.getElementById('sortOrder');

    function renderTable() {
        // 1) Ambil search term
        const searchTerm = searchInput.value.toLowerCase();

        // 2) Filter
        let filtered = rows.filter(r => {
            // Cek ke-lima field
            return (
                r.shiftNo.includes(searchTerm) ||
                r.date.includes(searchTerm) ||
                r.time.includes(searchTerm) ||
                r.remainingQuota.includes(searchTerm) ||
                r.taken.includes(searchTerm)
            );
        });

        // 3) Sort
        const sortColumn = sortColumnSelect.value;
        const sortOrder = sortOrderSelect.value; // 'asc' atau 'desc'
        if (sortColumn) {
            filtered.sort((a, b) => {
                let valA = a[sortColumn];
                let valB = b[sortColumn];

                // Kolom numeric
                if (sortColumn === 'remainingQuota' || sortColumn === 'taken') {
                    valA = parseInt(valA) || 0;
                    valB = parseInt(valB) || 0;
                }

                // Kolom string
                // 'asc' => a < b => -1
                if (valA < valB) return sortOrder === 'asc' ? -1 : 1;
                if (valA > valB) return sortOrder === 'asc' ? 1 : -1;
                return 0;
            });
        }

        // 4) Re-render ke table
        tableBody.innerHTML = '';
        filtered.forEach((r, index) => {
            // Update nomor (td[0]) => index + 1
            // Kita update isi cell "No."
            // (karena td[0] adalah nomor)
            let tds = r.element.querySelectorAll('td');
            tds[0].innerText = (index + 1) + ".";

            tableBody.appendChild(r.element);
        });
    }

    // Event listeners
    searchInput.addEventListener('input', renderTable);
    sortColumnSelect.addEventListener('change', renderTable);
    sortOrderSelect.addEventListener('change', renderTable);

    // Render awal
    renderTable();
});
</script>
@endsection
