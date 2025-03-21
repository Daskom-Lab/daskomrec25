@extends('admin.layouts.app')

@section('title', "Daftar CAAS Yang Belum Pilih Shift")

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
    class="text-2xl sm:text-3xl md:text-4xl font-im-fell-english
           text-white text-center sm:text-left"
>
    CAAS Yang Belum Memilih Shift di tahap {{ $currentStage }}
</h1>

        <!-- Tombol Back -->
        <div>
            <a 
                href="{{ route('admin.view-plot') }}"
                class="bg-biru-tua text-white rounded-[30px] 
                       px-4 py-3 sm:px-6 sm:py-4 
                       hover:opacity-90 hover:shadow-lg transition
                       text-lg sm:text-2xl font-im-fell-english"
            >
                Kembali ke View Plot
            </a>
        </div>
    </div>

    <!-- SUMMARY CARD -->
    <div class="bg-biru-tua rounded-[30px] p-6 mb-8 flex flex-col items-center shadow-md">
        <p class="text-white text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2 text-center">
            Total CAAS Belum Memilih Shift
        </p>
        <p class="text-white text-5xl sm:text-6xl md:text-7xl font-im-fell-english leading-tight">
            {{ count($caasNotPicked) }}
        </p>
    </div>

    <!-- TABEL CAAS YANG BELUM MEMILIH -->
    <div class="bg-custom-gray rounded-[30px] p-6 sm:p-8 shadow-lg">
        <!-- Search & Export Buttons -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
            <!-- SEARCH -->
            <div class="relative w-full md:w-1/2">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-biru-tua" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input 
                    type="text" 
                    id="searchInput"
                    class="bg-white border border-biru-tua rounded-[30px] pl-10 pr-4 py-3 w-full
                           focus:outline-none focus:ring-2 focus:ring-biru-tua focus:border-biru-tua
                           text-sm sm:text-base shadow-sm"
                    placeholder="Search across all fields..."
                >
            </div>

            <!-- Bagian Sorting -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                <div class="flex items-center space-x-2">
                    <label 
                        for="sortColumn"
                        class="text-biru-tua text-base sm:text-lg md:text-xl font-im-fell-english"
                    >
                        Sort By
                    </label>
                    <select 
                        id="sortColumn"
                        class="bg-white border border-biru-tua rounded-[30px] px-4 py-2 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-biru-tua"
                    >
                        <option value="">No Sorting</option>
                        <option value="nim">NIM</option>
                        <option value="name">Nama</option>
                        <option value="email">Email</option>
                        <option value="major">Jurusan</option>
                        <option value="class">Kelas</option>
                        <option value="gems">Gems</option>
                        <option value="status">Status</option>
                        <option value="state">State</option>
                    </select>
                    <select 
                        id="sortOrder"
                        class="bg-white border border-biru-tua rounded-[30px] px-4 py-2 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-biru-tua"
                    >
                        <option value="asc" selected>Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Table Container with Shadow and Rounded Corners -->
        <div class="rounded-[20px] shadow-xl overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead class="bg-biru-tua">
                        <tr>
                            <th 
                                class="py-4 px-4 border-r border-gray-300 text-white
                                       font-im-fell-english text-sm sm:text-base md:text-lg text-center"
                                style="width: 5%;"
                            >
                                No.
                            </th>
                            <th 
                                class="py-4 px-4 border-r border-gray-300 text-white
                                       font-im-fell-english text-sm sm:text-base md:text-lg text-center"
                                style="width: 10%;"
                            >
                                NIM
                            </th>
                            <th 
                                class="py-4 px-4 border-r border-gray-300 text-white
                                       font-im-fell-english text-sm sm:text-base md:text-lg text-center"
                                style="width: 15%;"
                            >
                                Nama
                            </th>
                            <th 
                                class="py-4 px-4 border-r border-gray-300 text-white
                                       font-im-fell-english text-sm sm:text-base md:text-lg text-center"
                                style="width: 15%;"
                            >
                                Email
                            </th>
                            <th 
                                class="py-4 px-4 border-r border-gray-300 text-white
                                       font-im-fell-english text-sm sm:text-base md:text-lg text-center"
                                style="width: 15%;"
                            >
                                Jurusan
                            </th>
                            <th 
                                class="py-4 px-4 border-r border-gray-300 text-white
                                       font-im-fell-english text-sm sm:text-base md:text-lg text-center"
                                style="width: 15%;"
                            >
                                Kelas
                            </th>
                            <th 
                                class="py-4 px-4 border-r border-gray-300 text-white
                                       font-im-fell-english text-sm sm:text-base md:text-lg text-center"
                                style="width: 8%;"
                            >
                                Gems
                            </th>
                            <th 
                                class="py-4 px-4 border-r border-gray-300 text-white
                                       font-im-fell-english text-sm sm:text-base md:text-lg text-center"
                                style="width: 8%;"
                            >
                                Status
                            </th>
                            <th 
                                class="py-4 px-4 border-r border-gray-300 text-white
                                       font-im-fell-english text-sm sm:text-base md:text-lg text-center"
                                style="width: 9%;"
                            >
                                State
                            </th>
                            <th 
                                class="py-4 px-4 text-white
                                       font-im-fell-english text-sm sm:text-base md:text-lg text-center"
                                style="width: 9%;"
                            >
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="caasTableBody">
                        @forelse($caasNotPicked as $index => $caas)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td 
                                    class="py-4 px-4 border-r border-gray-200 text-biru-tua
                                           font-im-fell-english text-sm sm:text-base text-center"
                                >
                                    {{ $index + 1 }}
                                </td>
                                <td 
                                    class="py-4 px-4 border-r border-gray-200 text-biru-tua
                                           font-im-fell-english text-sm sm:text-base text-center"
                                >
                                    {{ $caas->user->nim ?? '-' }}
                                </td>
                                <td 
                                    class="py-4 px-4 border-r border-gray-200 text-biru-tua
                                           font-im-fell-english text-sm sm:text-base text-center"
                                >
                                    {{ $caas->user->profile->name ?? '-' }}
                                </td>
                                <td 
                                    class="py-4 px-4 border-r border-gray-200 text-biru-tua
                                           font-im-fell-english text-sm sm:text-base text-center"
                                >
                                    {{ $caas->user->profile->email ?? '-' }}
                                </td>
                                <td 
                                    class="py-4 px-4 border-r border-gray-200 text-biru-tua
                                           font-im-fell-english text-sm sm:text-base text-center"
                                >
                                    {{ $caas->user->profile->major ?? '-' }}
                                </td>
                                <td 
                                    class="py-4 px-4 border-r border-gray-200 text-biru-tua
                                           font-im-fell-english text-sm sm:text-base text-center"
                                >
                                    {{ $caas->user->profile->class ?? 'N/A' }}
                                </td>
                                <td 
                                    class="py-4 px-4 border-r border-gray-200 text-biru-tua
                                           font-im-fell-english text-sm sm:text-base text-center"
                                >
                                    {{ $caas->role->name ?? 'No Gem' }}
                                </td>
                                <td 
                                    class="py-4 px-4 border-r border-gray-200
                                           font-im-fell-english text-sm sm:text-base text-center
                                           {{ strtolower($caas->user->caasStage->status ?? '') === 'pass' ? 'text-green-600 font-semibold' : '' }}
                                    {{ strtolower($caas->user->caasStage->status ?? '') === 'fail' ? 'text-red-600 font-semibold' : '' }}
                                    {{ !in_array(strtolower($caas->user->caasStage->status ?? ''), ['pass', 'fail']) ? 'text-biru-tua' : '' }}"
                                >
                                    {{ $caas->user->caasStage->status ?? 'Unknown' }}
                                </td>
                                <td 
    class="py-4 px-4 border-r border-gray-200 text-biru-tua
           font-im-fell-english text-sm sm:text-base text-center"
>
   {{ $caas->user->caasStage->stage->name ?? '-' }}
</td>
<!-- Tombol Add Jadwal -->
<td class="py-4 px-4 border-r border-gray-200 text-center">
    <a href="{{ route('admin.plot.assign-schedule', $caas->id) }}" 
       class="bg-green-600 text-white rounded-[30px] px-4 py-2
              hover:bg-opacity-90 hover:shadow-md transition
              font-im-fell-english text-sm sm:text-base inline-block">
        Add Jadwal
    </a>
</td>
                            </tr>
                        @empty
                            <tr>
                                <td 
                                    colspan="9" 
                                    class="py-10 px-3 text-biru-tua text-center
                                           font-im-fell-english text-base sm:text-lg"
                                >
                                    <div class="flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <p class="text-2xl mb-2">Semua CAAS sudah memilih shift.</p>
                                        <p class="text-gray-600">Tidak ada data yang perlu ditampilkan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- No Results Message (Hidden by default) -->
        <div id="noResultsMessage" class="hidden mt-6 py-8 px-6 bg-white rounded-[20px] shadow-md">
            <div class="flex flex-col items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-yellow-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <p class="text-2xl text-biru-tua font-im-fell-english mb-2">Tidak ada hasil yang ditemukan</p>
                <p class="text-gray-600 text-center max-w-md">Pencarian Anda tidak menemukan hasil yang sesuai. Silakan coba kata kunci yang berbeda atau reset filter.</p>
                <button 
                    id="resetSearchButton"
                    class="mt-4 bg-biru-tua text-white rounded-[30px] px-6 py-2 hover:bg-opacity-90 transition font-im-fell-english"
                >
                    Reset Pencarian
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Script Search & Sort (Client Side) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.getElementById('caasTableBody');
    const table = tableBody.closest('table');
    const tableContainer = table.closest('.overflow-hidden');
    const noResultsMessage = document.getElementById('noResultsMessage');
    const resetSearchButton = document.getElementById('resetSearchButton');
    
    // Skip if the table has the "semua CAAS sudah memilih shift" message
    if (tableBody.querySelector('td[colspan="9"]')) {
        return;
    }
    
    // Get all rows and create data objects for each
    const originalRows = Array.from(tableBody.querySelectorAll('tr'));
    let rows = originalRows.map((tr, index) => {
        const td = tr.querySelectorAll('td');
        return {
            element: tr,
            originalIndex: index,
            // Fields for searching and sorting
            nim: td[1].innerText.trim().toLowerCase(),
            name: td[2].innerText.trim().toLowerCase(),
            email: td[3].innerText.trim().toLowerCase(),
            major: td[4].innerText.trim().toLowerCase(),
            class: td[5].innerText.trim().toLowerCase(),
            gems: td[6].innerText.trim().toLowerCase(),
            status: td[7].innerText.trim().toLowerCase(),
            state: td[8].innerText.trim().toLowerCase()
        };
    });

    const searchInput = document.getElementById('searchInput');
    const sortColumnSelect = document.getElementById('sortColumn');
    const sortOrderSelect = document.getElementById('sortOrder');

    function renderTable() {
        // 1) Get search term
        const searchTerm = searchInput.value.toLowerCase();

        // 2) Filter rows based on search term
        let filtered = rows;
        
        if (searchTerm) {
            filtered = rows.filter(r => {
                // Check all fields for the search term
                return (
                    r.nim.includes(searchTerm) ||
                    r.name.includes(searchTerm) ||
                    r.email.includes(searchTerm) ||
                    r.major.includes(searchTerm) ||
                    r.class.includes(searchTerm) ||
                    r.gems.includes(searchTerm) ||
                    r.status.includes(searchTerm) ||
                    r.state.includes(searchTerm)
                );
            });
        }

        // 3) Sort filtered results
        const sortColumn = sortColumnSelect.value;
        const sortOrder = sortOrderSelect.value; // 'asc' or 'desc'
        
        if (sortColumn) {
            filtered.sort((a, b) => {
                let valA = a[sortColumn];
                let valB = b[sortColumn];

                // For ascending/descending
                if (valA < valB) return sortOrder === 'asc' ? -1 : 1;
                if (valA > valB) return sortOrder === 'asc' ? 1 : -1;
                
                // If values are the same, maintain original order
                return a.originalIndex - b.originalIndex;
            });
        }

        // 4) Re-render the table with filtered and sorted data
        tableBody.innerHTML = '';
        
        if (filtered.length === 0) {
            // Show "no results" message and hide table
            tableContainer.classList.add('hidden');
            noResultsMessage.classList.remove('hidden');
        } else {
            // Hide "no results" message and show table
            tableContainer.classList.remove('hidden');
            noResultsMessage.classList.add('hidden');
            
            // Append rows to table body in sorted/filtered order
            filtered.forEach((row, index) => {
                // Update the row number
                const tds = row.element.querySelectorAll('td');
                tds[0].innerText = (index + 1);
                tableBody.appendChild(row.element);
            });
        }
    }

    // Reset search and sort values and re-render table
    resetSearchButton.addEventListener('click', function() {
        searchInput.value = '';
        sortColumnSelect.value = '';
        sortOrderSelect.value = 'asc';
        renderTable();
        searchInput.focus();
    });

    // Add event listeners for search and sort controls
    searchInput.addEventListener('input', renderTable);
    sortColumnSelect.addEventListener('change', renderTable);
    sortOrderSelect.addEventListener('change', renderTable);

    // Initial table render
    renderTable();
});
</script>
@endsection