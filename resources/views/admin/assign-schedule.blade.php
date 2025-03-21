@extends('admin.layouts.app')

@section('title', "Assign Schedule untuk CAAS")

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
            Assign Jadwal untuk CAAS
        </h1>

        <!-- Tombol Back -->
        <div>
            <a 
            href="{{ route('admin.plot.havenpicked') }}" 
                class="bg-biru-tua text-white rounded-[30px] 
                       px-4 py-3 sm:px-6 sm:py-4 
                       hover:opacity-90 hover:shadow-lg transition
                       text-lg sm:text-2xl font-im-fell-english"
            >
                Kembali
            </a>
        </div>
    </div>

    <!-- CAAS INFO CARD -->
    <div class="bg-biru-tua rounded-[30px] p-6 mb-8 flex flex-col md:flex-row justify-between items-center shadow-md">
        <div>
            <p class="text-white text-xl sm:text-2xl font-im-fell-english mb-2">
                {{ $caas->user->profile->name ?? 'Unknown' }}
            </p>
            <p class="text-white text-base sm:text-lg font-im-fell-english opacity-90">
                NIM: {{ $caas->user->nim ?? 'N/A' }}
            </p>
            <p class="text-white text-base sm:text-lg font-im-fell-english opacity-90">
                Status: <span class="{{ strtolower($caas->user->caasStage->status ?? '') === 'pass' ? 'text-green-300 font-semibold' : '' }}
                               {{ strtolower($caas->user->caasStage->status ?? '') === 'fail' ? 'text-red-300 font-semibold' : '' }}">
                          {{ $caas->user->caasStage->status ?? 'Unknown' }}
                      </span>
            </p>
        </div>
        <div class="mt-4 md:mt-0">
            <p class="text-white text-base sm:text-lg font-im-fell-english opacity-90">
                Jurusan: {{ $caas->user->profile->major ?? 'N/A' }}
            </p>
            <p class="text-white text-base sm:text-lg font-im-fell-english opacity-90">
                Kelas: {{ $caas->user->profile->class ?? 'N/A' }}
            </p>
            <p class="text-white text-base sm:text-lg font-im-fell-english opacity-90">
                Gems: {{ $caas->role->name ?? 'No Gem' }}
            </p>
        </div>
    </div>

    <!-- ERROR MESSAGE -->
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-lg shadow-md">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <p class="font-im-fell-english text-base sm:text-lg">{{ session('error') }}</p>
            </div>
        </div>
    @endif
    
    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-lg shadow-md">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <p class="font-im-fell-english text-base sm:text-lg">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- SHIFT TABLE CARD -->
    <div class="bg-custom-gray rounded-[30px] p-6 sm:p-8 shadow-lg">
        <h2 class="text-xl sm:text-2xl md:text-3xl font-im-fell-english text-biru-tua mb-6 text-center sm:text-left">
            Daftar Shift Tersedia
        </h2>
        
        @if($shifts->isEmpty())
            <div class="bg-white rounded-[20px] p-8 text-center shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-yellow-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-xl font-im-fell-english text-gray-700 mb-2">Tidak ada shift yang tersedia</p>
                <p class="text-gray-500 max-w-md mx-auto">Semua shift sudah terisi penuh atau belum ada shift yang dibuat untuk tahap ini.</p>
            </div>
        @else
            <form id="assignForm" action="{{ route('admin.plot.assign-schedule.store') }}" method="POST">
                @csrf
                <input type="hidden" name="caas_id" value="{{ $caas->id }}">
                
                <!-- SEARCH & FILTER -->
                <div class="mb-6 flex flex-col sm:flex-row justify-between gap-4">
                    <div class="relative w-full sm:w-1/2">
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
                            placeholder="Search by date or shift number..."
                        >
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <label 
                            for="filterAvailable"
                            class="text-biru-tua text-base sm:text-lg font-im-fell-english"
                        >
                            Show only:
                        </label>
                        <select 
                            id="filterAvailable"
                            class="bg-white border border-biru-tua rounded-[30px] px-4 py-2 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-biru-tua"
                        >
                            <option value="all">All Shifts</option>
                            <option value="available" selected>Available Slots</option>
                        </select>
                    </div>
                </div>
                
                <!-- Table Container with Shadow and Rounded Corners -->
                <div class="rounded-[20px] shadow-xl overflow-hidden border border-gray-200 mb-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-biru-tua">
                                <tr>
                                    <th class="py-4 px-4 border-r border-gray-300 text-white font-im-fell-english text-center">
                                        Shift No
                                    </th>
                                    <th class="py-4 px-4 border-r border-gray-300 text-white font-im-fell-english text-center">
                                        Tanggal
                                    </th>
                                    <th class="py-4 px-4 border-r border-gray-300 text-white font-im-fell-english text-center">
                                        Waktu
                                    </th>
                                    <th class="py-4 px-4 border-r border-gray-300 text-white font-im-fell-english text-center">
                                        Kuota
                                    </th>
                                    <th class="py-4 px-4 border-r border-gray-300 text-white font-im-fell-english text-center">
                                        Sisa Kuota
                                    </th>
                                    <th class="py-4 px-4 text-white font-im-fell-english text-center">
                                        Pilih
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="shiftsTableBody">
                                @foreach($shifts as $shift)
                                <tr class="border-b hover:bg-gray-50 transition-colors shift-row {{ $shift->kuota - $shift->plottingans_count <= 0 ? 'unavailable-shift bg-gray-100' : '' }}"
                                    data-shift-no="{{ $shift->shift_no }}"
                                    data-date="{{ $shift->date }}"
                                    data-available="{{ $shift->kuota - $shift->plottingans_count }}">
                                    <td class="py-4 px-4 border-r border-gray-200 text-biru-tua font-im-fell-english text-center">
                                        {{ $shift->shift_no }}
                                    </td>
                                    <td class="py-4 px-4 border-r border-gray-200 text-biru-tua font-im-fell-english text-center">
                                        {{ \Carbon\Carbon::parse($shift->date)->format('d M Y') }}
                                    </td>
                                    <td class="py-4 px-4 border-r border-gray-200 text-biru-tua font-im-fell-english text-center">
                                        {{ substr($shift->time_start, 0, 5) }} - {{ substr($shift->time_end, 0, 5) }}
                                    </td>
                                    <td class="py-4 px-4 border-r border-gray-200 text-biru-tua font-im-fell-english text-center">
                                        {{ $shift->kuota }}
                                    </td>
                                    <td class="py-4 px-4 border-r border-gray-200 font-im-fell-english text-center
                                           {{ $shift->kuota - $shift->plottingans_count <= 0 ? 'text-red-600' : 'text-green-600' }}">
                                        {{ $shift->kuota - $shift->plottingans_count }}
                                    </td>
                                    <td class="py-4 px-4 text-biru-tua font-im-fell-english text-center">
                                        <input type="radio" name="shift_id" value="{{ $shift->id }}" required
                                               {{ $shift->kuota - $shift->plottingans_count <= 0 ? 'disabled' : '' }}
                                               class="w-5 h-5 text-biru-tua focus:ring-biru-tua">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- No Results Message (Hidden by default) -->
                <div id="noResultsMessage" class="hidden mt-4 py-8 px-6 bg-white rounded-[20px] shadow-md text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="text-xl text-biru-tua font-im-fell-english mb-2">Tidak ada hasil yang ditemukan</p>
                    <p class="text-gray-600 text-center max-w-md mx-auto">Pencarian Anda tidak menemukan hasil yang sesuai. Silakan coba kata kunci yang berbeda atau reset filter.</p>
                    <button 
                        id="resetSearchButton"
                        type="button"
                        class="mt-4 bg-biru-tua text-white rounded-[30px] px-6 py-2 hover:bg-opacity-90 transition font-im-fell-english"
                    >
                        Reset Pencarian
                    </button>
                </div>
                
                <!-- BUTTONS -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mt-8">
                    <button 
                        type="button" 
                        id="assignButton"
                        class="bg-green-600 text-white rounded-[30px] 
                               px-6 py-3 
                               hover:bg-opacity-90 hover:shadow-lg transition
                               text-lg font-im-fell-english w-full sm:w-auto"
                    >
                        Assign Jadwal
                    </button>
                    <a 
                    href="{{ route('admin.plot.havenpicked') }}" 
                        class="bg-gray-600 text-white rounded-[30px] 
                               px-6 py-3 
                               hover:bg-opacity-90 hover:shadow-lg transition
                               text-lg font-im-fell-english text-center w-full sm:w-auto"
                    >
                        Batal
                    </a>
                </div>
            </form>
        @endif
    </div>
</div>

<!-- Confirmation Modal (Hidden by default) -->
<div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-[30px] p-8 max-w-md w-full mx-4 shadow-2xl transform transition-transform duration-300 scale-100">
        <div class="text-center mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-yellow-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <h3 class="text-2xl font-im-fell-english text-biru-tua mb-2">Konfirmasi Assign Jadwal</h3>
        </div>
        
        <p class="text-gray-700 font-im-fell-english text-lg mb-2">
            Anda akan meng-assign CAAS:
        </p>
        <p class="font-im-fell-english text-biru-tua text-xl mb-4">
            {{ $caas->user->profile->name ?? 'Unknown' }} ({{ $caas->user->nim ?? 'N/A' }})
        </p>
        
        <p class="text-gray-700 font-im-fell-english text-lg mb-2">
            ke Shift:
        </p>
        <div class="bg-gray-100 rounded-lg p-4 mb-6">
            <p id="confirmShiftNo" class="font-im-fell-english text-biru-tua text-lg">
                Shift #<span id="shiftNoText">--</span>
            </p>
            <p id="confirmShiftDate" class="font-im-fell-english text-biru-tua text-lg">
                Tanggal: <span id="shiftDateText">--</span>
            </p>
            <p id="confirmShiftTime" class="font-im-fell-english text-biru-tua text-lg">
                Waktu: <span id="shiftTimeText">--</span>
            </p>
        </div>
        
        <p class="text-gray-700 mb-6 italic text-sm">
            * CAAS akan diberitahu tentang pilihan jadwal ini. Tindakan ini tidak dapat dibatalkan.
        </p>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <button 
                id="confirmButton"
                class="bg-green-600 text-white rounded-[30px] 
                       px-6 py-3 
                       hover:bg-opacity-90 hover:shadow-lg transition
                       text-lg font-im-fell-english w-full sm:w-auto"
            >
                Konfirmasi
            </button>
            <button 
                id="cancelButton"
                class="bg-gray-600 text-white rounded-[30px] 
                       px-6 py-3 
                       hover:bg-opacity-90 hover:shadow-lg transition
                       text-lg font-im-fell-english w-full sm:w-auto"
            >
                Batal
            </button>
        </div>
    </div>
</div>

<!-- Script for Search, Filter, and Modal -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const tableBody = document.getElementById('shiftsTableBody');
    const searchInput = document.getElementById('searchInput');
    const filterSelect = document.getElementById('filterAvailable');
    const resetButton = document.getElementById('resetSearchButton');
    const noResultsMessage = document.getElementById('noResultsMessage');
    const table = tableBody.closest('table');
    const tableContainer = table.closest('.overflow-hidden');
    
    // Modal Elements
    const confirmationModal = document.getElementById('confirmationModal');
    const assignButton = document.getElementById('assignButton');
    const confirmButton = document.getElementById('confirmButton');
    const cancelButton = document.getElementById('cancelButton');
    const shiftNoText = document.getElementById('shiftNoText');
    const shiftDateText = document.getElementById('shiftDateText');
    const shiftTimeText = document.getElementById('shiftTimeText');
    
    // Get all rows
    const rows = Array.from(tableBody.querySelectorAll('tr'));
    
    // Search and Filter Function
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const filterValue = filterSelect.value;
        
        let visibleCount = 0;
        
        rows.forEach(row => {
            const shiftNo = row.getAttribute('data-shift-no').toLowerCase();
            const date = row.getAttribute('data-date').toLowerCase();
            const available = parseInt(row.getAttribute('data-available'));
            
            // Check if row matches search criteria
            const matchesSearch = !searchTerm || 
                                 shiftNo.includes(searchTerm) || 
                                 date.includes(searchTerm);
            
            // Check if row matches filter criteria
            const matchesFilter = filterValue === 'all' || 
                                (filterValue === 'available' && available > 0);
            
            // Show/hide row based on both criteria
            if (matchesSearch && matchesFilter) {
                row.classList.remove('hidden');
                visibleCount++;
            } else {
                row.classList.add('hidden');
            }
        });
        
        // Show/hide no results message
        if (visibleCount === 0) {
            tableContainer.classList.add('hidden');
            noResultsMessage.classList.remove('hidden');
        } else {
            tableContainer.classList.remove('hidden');
            noResultsMessage.classList.add('hidden');
        }
    }
    
    // Reset Search and Filter
    resetButton.addEventListener('click', function() {
        searchInput.value = '';
        filterSelect.value = 'available';
        filterTable();
    });
    
    // Add event listeners for search and filter
    searchInput.addEventListener('input', filterTable);
    filterSelect.addEventListener('change', filterTable);
    
    // Initial filter (to hide full shifts)
    filterTable();
    
    // Modal Functionality
    assignButton.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Get selected shift
        const selectedShift = document.querySelector('input[name="shift_id"]:checked');
        
        if (!selectedShift) {
            alert('Silakan pilih shift terlebih dahulu!');
            return;
        }
        
        // Get shift details for modal
        const row = selectedShift.closest('tr');
        const cells = row.querySelectorAll('td');
        
        shiftNoText.textContent = cells[0].textContent.trim();
        shiftDateText.textContent = cells[1].textContent.trim();
        shiftTimeText.textContent = cells[2].textContent.trim();
        
        // Show modal with animation
        confirmationModal.classList.remove('hidden');
        setTimeout(() => {
            confirmationModal.querySelector('div').classList.add('scale-100');
        }, 10);
    });
    
    // Confirm Button Action
    confirmButton.addEventListener('click', function() {
        document.getElementById('assignForm').submit();
    });
    
    // Cancel Button Action
    cancelButton.addEventListener('click', function() {
        // Hide modal with animation
        confirmationModal.querySelector('div').classList.remove('scale-100');
        setTimeout(() => {
            confirmationModal.classList.add('hidden');
        }, 300);
    });
    
    // Close modal if clicked outside
    confirmationModal.addEventListener('click', function(e) {
        if (e.target === confirmationModal) {
            cancelButton.click();
        }
    });
    
    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !confirmationModal.classList.contains('hidden')) {
            cancelButton.click();
        }
    });
});
</script>
@endsection