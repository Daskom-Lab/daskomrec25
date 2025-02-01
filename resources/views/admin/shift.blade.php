@extends('admin.layouts.app')

@section('title', 'Manage Shift - Crystal Cavern')

{{-- Jika pakai Alpine.js, pastikan sudah ada import Alpine, misal di layout --}}
@push('scripts')
<script>
async function importShift(file) {
    try {
        const formData = new FormData();
        formData.append("file", file);
        formData._method = "patch";
        const response = await fetch("/admin/shift/import", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: formData,
        });

        if (!response.ok) {
            throw new Error('Failed to import shifts');
        }
    } catch (error) {
        console.error('Error:', error);
        throw error;
    }
}


    function manageShift() {
        return {
            shiftList: {!! $shifts->map(function($shift){
                return [
                    'id'        => $shift->id,
                    'shiftNo'   => $shift->shift_no,
                    'date'      => $shift->date,
                    'timeStart' => $shift->time_start,
                    'timeEnd'   => $shift->time_end,
                    'kuota'     => $shift->kuota,
                ];
            })->toJson() !!},

            // Search & Pagination
            searchTerm: '',
            showEntries: 10,
            currentPage: 1,

            // Modal flags
            isResetPlotOpen: false,
            isResetShiftOpen: false,
            isAddOpen: false,
            isViewOpen: false,
            isEditOpen: false,
            isDeleteOpen: false,
            isImportOpen: false,

            // Data form "Add Shift"
            addShiftNo: '',
            addDate: '',
            addTimeStart: '',
            addTimeEnd: '',
            addQuota: '',

            // Data terpilih (untuk View/Edit/Delete)
            selectedShift: null,

            // ----------------------
            // Import file
            // ----------------------
            chosenFile: null,
            isLoading: false,
            timer: null,
            elapsedTime: 0,

            // -------------
            // Computed / Getter
            // -------------
            get filteredList() {
                const term = this.searchTerm.toLowerCase().trim();
                if (!term) return this.shiftList;
                return this.shiftList.filter(item =>
                    item.date.toLowerCase().includes(term) ||
                    item.shiftNo.toLowerCase().includes(term) ||
                    item.timeStart.toLowerCase().includes(term) ||
                    item.timeEnd.toLowerCase().includes(term) ||
                    new Date(item.date).toLocaleDateString('id-ID', { weekday: 'long', day: '2-digit', month: 'long', year: 'numeric' }).toLowerCase().includes(term) ||
                    new Date(item.date).toLocaleDateString('en-US', { weekday: 'long', day: '2-digit', month: 'long', year: 'numeric' }).toLowerCase().includes(term)
                );
            },
            get totalPages() {
                return Math.ceil(this.filteredList.length / this.showEntries);
            },
            get paginatedData() {
                const start = (this.currentPage - 1) * this.showEntries;
                const end = start + parseInt(this.showEntries);
                return this.filteredList.slice(start, end);
            },
            get showingText() {
                if (this.filteredList.length === 0) {
                    return 'Showing 0 to 0 of 0 entries';
                }
                const start = (this.currentPage - 1) * this.showEntries + 1;
                const end = Math.min(this.currentPage * this.showEntries, this.filteredList.length);
                return `Showing ${start} to ${end} of ${this.filteredList.length} entries`;
            },

            // -------------
            // Methods: Pagination
            // -------------
            goToPage(page) {
                if (page >= 1 && page <= this.totalPages) {
                    this.currentPage = page;
                }
            },
            nextPage() {
                if (this.currentPage < this.totalPages) {
                    this.currentPage++;
                }
            },
            prevPage() {
                if (this.currentPage > 1) {
                    this.currentPage--;
                }
            },

            // -------------
            // Methods: View / Edit / Delete
            // -------------
            viewShift(shift) {
                // Clone data shift ke selectedShift
                this.selectedShift = JSON.parse(JSON.stringify(shift));
                this.isViewOpen = true;
            },
            editShift(shift) {
                this.selectedShift = JSON.parse(JSON.stringify(shift));
                this.isEditOpen = true;
            },
            confirmDelete(shift) {
                this.selectedShift = JSON.parse(JSON.stringify(shift));
                this.isDeleteOpen = true;
            },
            // Modal "Import Excel"
            async saveImport() {
                console.log("Selected file:", this.chosenFile);

                if (!this.chosenFile) {
                    alert("No file selected!");
                    return;
                }

                // Show loading indicator
                this.isLoading = true;
                this.elapsedTime = 0;

                // Start a timer to track elapsed time
                this.timer = setInterval(() => {
                    this.elapsedTime++;
                }, 1000); // Increment every 1 second

                try {
                    // Call importCaas and wait for it to complete
                    await importShift(this.chosenFile);

                    // Reload after the import completes
                    window.location.reload();
                } catch (error) {
                    console.error("Import failed:", error);
                    alert("Import failed. Please try again.");
                } finally {
                    // Stop the timer and hide loading indicator
                    clearInterval(this.timer);
                    this.isLoading = false;
                    this.isImportOpen = false;
                    this.resetImport();
                }
            },
            resetImport() {
                this.chosenFile = null;
            },
        }
    }
</script>
@endpush

@section('content')
<div 
    class="relative w-full max-w-screen-2xl mx-auto px-4 sm:px-6 md:px-8 py-6"
    x-data="manageShift()"
>
    <!-- FLASH MESSAGES (opsional) -->
    @if(session('success'))
        <div class="bg-green-400 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-400 text-white p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Judul Halaman -->
    <h1 class="text-center text-white text-3xl sm:text-4xl md:text-5xl font-im-fell-english mt-4">
        Manage Shift
    </h1>

    <!-- Tombol utama (Reset Plot, Reset Shift, View Plot, Add Shift) -->
    <div class="mt-8 bg-abu-abu-keunguan rounded-2xl p-6 sm:p-8 w-full px-4">
        <div class="flex flex-col md:flex-row gap-4">
            <!-- Reset Plot -->
            <form method="POST" action="{{ route('admin.shift.resetPlot') }}" 
                  onsubmit="return confirm('Are you sure you want to reset all plots?');"
                  class="flex-1">
                @csrf
                <button
                    type="submit"
                    class="w-full bg-merah-tua text-white font-im-fell-english
                           rounded-[30px] py-4 sm:py-6 md:py-6
                           text-lg sm:text-2xl md:text-3xl text-center
                           hover:opacity-90 hover:shadow-lg transition"
                >
                    Reset Plot
                </button>
            </form>

            <!-- Reset Shift -->
            <form method="POST" action="{{ route('admin.shift.resetShifts') }}" 
                  onsubmit="return confirm('Are you sure you want to reset all shifts?');"
                  class="flex-1">
                @csrf
                <button
                    type="submit"
                    class="w-full bg-biru-tua text-white font-im-fell-english
                           rounded-[30px] py-4 sm:py-6 md:py-6
                           text-lg sm:text-2xl md:text-3xl text-center
                           hover:opacity-90 hover:shadow-lg transition"
                >
                    Reset Shift
                </button>
            </form>

            <!-- Add Shift (open modal) -->
            <button
                x-cloak
                class="flex-1 bg-custom-green text-white font-im-fell-english
                       rounded-[30px] py-4 sm:py-6 md:py-6
                       text-lg sm:text-2xl md:text-3xl text-center
                       hover:opacity-90 hover:shadow-lg transition"
                @click="isAddOpen = true"
            >
                Add Shift
            </button>
            <!-- Import Excel -->
            <button
                x-cloak
                class="flex-1 bg-hijau-tua text-white font-im-fell-english
                       rounded-[30px] py-4 sm:py-6 md:py-6
                       text-lg sm:text-2xl md:text-3xl text-center
                       hover:opacity-90 hover:shadow-lg transition"
                @click="isImportOpen = true"
            >
                Import Excel
            </button>
            <!-- View Plot -->
            <a href="{{ route('admin.view-plot') }}"
               class="flex-1 bg-ungu-muda text-white font-im-fell-english
                      rounded-[30px] py-4 sm:py-6 md:py-6
                      text-lg sm:text-2xl md:text-3xl text-center
                      hover:opacity-90 hover:shadow-lg transition"
            >
                View Plot
            </a>
        </div>
    </div>

    <!-- Beberapa Statistik (Contoh) -->
    <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-6">
        <!-- Total Shifts -->
        <div class="bg-abu-abu-keunguan rounded-2xl p-4 sm:p-6 flex flex-col items-center">
            <p class="text-biru-tua text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2">
                Total Shifts
            </p>
            <p class="text-biru-tua text-4xl sm:text-5xl md:text-6xl font-im-fell-english leading-tight">
                <span x-text="shiftList.length"></span>
            </p>
        </div>
        <!-- Earliest Date (contoh ambil index ke-0, pastikan shiftList sudah sort by date) -->
        <div class="bg-abu-abu-keunguan rounded-2xl p-4 sm:p-6 flex flex-col items-center">
            <p class="text-biru-tua text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2">
                Earliest Date
            </p>
            <p class="text-biru-tua text-2xl sm:text-3xl md:text-4xl font-im-fell-english leading-tight">
                <span x-text="shiftList.length ? shiftList[0].date : '-'"></span>
            </p>
        </div>
        <!-- Largest Quota (cari max kuota) -->
        <div class="bg-abu-abu-keunguan rounded-2xl p-4 sm:p-6 flex flex-col items-center">
            <p class="text-biru-tua text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2">
                Largest Quota
            </p>
            <p class="text-biru-tua text-2xl sm:text-3xl md:text-4xl font-im-fell-english leading-tight">
                <span x-text="shiftList.length 
                    ? Math.max(...shiftList.map(s => s.kuota))
                    : 0"></span>
            </p>
        </div>
    </div>

    <!-- Tabel Shift -->
    <div class="mt-8 bg-custom-gray rounded-2xl p-4 sm:p-6 md:p-8">
        <!-- Show Entries & Search -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4">
            <!-- Show Entries -->
            <div class="flex items-center space-x-2 mb-3 md:mb-0">
                <label class="text-biru-tua text-base sm:text-lg md:text-xl font-im-fell-english">
                    Show
                </label>
                <input 
                    type="number" 
                    x-model="showEntries"
                    min="1"
                    class="w-16 bg-white border border-black rounded-[10px] p-1 
                           text-center focus:outline-none focus:ring-1 focus:ring-biru-tua
                           text-sm sm:text-base"
                >
                <label class="text-biru-tua text-base sm:text-lg md:text-xl font-im-fell-english">
                    Entries
                </label>
            </div>
            <!-- Search -->
            <div class="flex items-center space-x-2">
                <label class="text-biru-tua text-base sm:text-lg md:text-xl font-im-fell-english">
                    Search
                </label>
                <input 
                    type="text" 
                    x-model="searchTerm"
                    class="bg-white border border-black rounded-[30px] px-3 py-1 
                           focus:outline-none focus:ring-1 focus:ring-biru-tua
                           text-sm sm:text-base"
                    placeholder="Search shift..."
                >
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full border border-black rounded-md overflow-hidden table-auto">
                <thead class="bg-white">
                    <tr class="border-b border-black">
                        <th class="py-3 px-3 border-r border-black text-biru-tua
                                   font-im-fell-english text-sm sm:text-base md:text-lg">
                            No.
                        </th>
                        <th class="py-3 px-3 border-r border-black text-biru-tua
                                   font-im-fell-english text-sm sm:text-base md:text-lg">
                            Date
                        </th>
                        <th class="py-3 px-3 border-r border-black text-biru-tua
                                   font-im-fell-english text-sm sm:text-base md:text-lg">
                            Shift No.
                        </th>
                        <th class="py-3 px-3 border-r border-black text-biru-tua
                                   font-im-fell-english text-sm sm:text-base md:text-lg">
                            Time
                        </th>
                        <th class="py-3 px-3 border-r border-black text-biru-tua
                                   font-im-fell-english text-sm sm:text-base md:text-lg">
                            Initial Quota
                        </th>
                        <th class="py-3 px-3 text-biru-tua
                                   font-im-fell-english text-sm sm:text-base md:text-lg">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <template x-for="(shift, i) in paginatedData" :key="shift.id">
                        <tr class="border-b border-black last:border-b-0">
                            <!-- No -->
                            <td class="py-3 px-3 border-r border-black text-biru-tua text-center
                                       font-im-fell-english text-sm sm:text-base">
                                <span x-text="(currentPage - 1) * showEntries + i + 1"></span>.
                            </td>
                            <!-- Date -->
                            <td class="py-3 px-3 border-r border-black text-biru-tua text-center
                                       font-im-fell-english text-sm sm:text-base"
                                x-text="new Date(shift.date).toLocaleDateString('en-US', { weekday: 'long', day: '2-digit', month: 'long', year: 'numeric' })">
                            ></td>
                            <!-- Shift No -->
                            <td class="py-3 px-3 border-r border-black text-biru-tua text-center
                                       font-im-fell-english text-sm sm:text-base"
                                x-text="shift.shiftNo"
                            ></td>
                            <!-- Time -->
                            <td class="py-3 px-3 border-r border-black text-biru-tua text-center
                                       font-im-fell-english text-sm sm:text-base">
                                <span x-text="shift.timeStart.slice(0, 5) + '-' + shift.timeEnd.slice(0, 5)"></span>
                            </td>
                            <!-- Quota -->
                            <td class="py-3 px-3 border-r border-black text-biru-tua text-center
                                       font-im-fell-english text-sm sm:text-base"
                                x-text="shift.kuota"
                            ></td>
                            <!-- Action -->
                            <td class="py-3 px-3 text-biru-tua
                                       font-im-fell-english text-sm sm:text-base">
                                <div class="flex flex-wrap gap-2">
                                    <button 
                                        class="bg-hijau-tua rounded-[15px] px-3 py-1 text-white
                                               hover:opacity-90 hover:shadow-md transition"
                                        @click="viewShift(shift)"
                                    >
                                        View
                                    </button>
                                    <button 
                                        class="bg-biru-tua rounded-[15px] px-3 py-1 text-white
                                               hover:opacity-90 hover:shadow-md transition"
                                        @click="editShift(shift)"
                                    >
                                        Edit
                                    </button>
                                    <button 
                                        class="bg-merah-tua rounded-[15px] px-3 py-1 text-white
                                               hover:opacity-90 hover:shadow-md transition"
                                        @click="confirmDelete(shift)"
                                    >
                                        Erase
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- Info 'Showing x to y of z entries' -->
        <div class="mt-4 text-sm sm:text-base text-biru-tua" x-text="showingText"></div>

        <!-- Navigasi pagination -->
        <div class="mt-2 flex items-center space-x-2 text-sm sm:text-base text-biru-tua">
            <button 
                class="px-2 py-1 border rounded disabled:opacity-50"
                :disabled="currentPage <= 1"
                @click="prevPage"
            >
                Previous
            </button>
            <template x-for="page in totalPages" :key="page">
                <button 
                    class="px-2 py-1 border rounded"
                    :class="currentPage === page ? 'bg-biru-tua text-white' : ''"
                    @click="goToPage(page)"
                    x-text="page"
                ></button>
            </template>
            <button 
                class="px-2 py-1 border rounded disabled:opacity-50"
                :disabled="currentPage >= totalPages"
                @click="nextPage"
            >
                Next
            </button>
        </div>
    </div>

    <!-- ========================================
         MODALS
    ======================================== -->

    <!-- MODAL: Add Shift (Form submission ke SHIFT STORE) -->
    <div 
    x-cloak
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        x-show="isAddOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
    >
        <div class="bg-biru-tua text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-lg relative">
            <!-- Close -->
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isAddOpen = false"
            >
                &times;
            </button>
            <h2 class="text-3xl sm:text-4xl font-im-fell-english mb-4">
                Add Shift
            </h2>
            <hr class="border-white/50 mb-6" />

            <!-- Form Add Shift -->
            <form method="POST" action="{{ route('admin.shift.store') }}">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-biru-tua">
                    <!-- Shift No -->
                    <div>
                        <label class="block text-xl mb-1 text-white">Shift No.</label>
                        <input 
                            type="text"
                            name="shift_no"
                            class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                            x-model="addShiftNo"
                            placeholder="Misal: 1, 2, 3..."
                            required
                        >
                    </div>
                    <!-- Date -->
                    <div>
                        <label class="block text-xl mb-1 text-white">Date</label>
                        <input 
                            type="date"
                            name="date"
                            class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                            x-model="addDate"
                            required
                        >
                    </div>
                    <!-- Time Start -->
                    <div>
                        <label class="block text-xl mb-1 text-white">Time Start</label>
                        <input 
                            type="time"
                            name="time_start"
                            class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                            x-model="addTimeStart"
                            required
                        >
                    </div>
                    <!-- Time End -->
                    <div>
                        <label class="block text-xl mb-1 text-white">Time End</label>
                        <input 
                            type="time"
                            name="time_end"
                            class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                            x-model="addTimeEnd"
                            required
                        >
                    </div>
                    <!-- Quota -->
                    <div>
                        <label class="block text-xl mb-1 text-white">Initial Quota</label>
                        <input 
                            type="number"
                            name="kuota"
                            min="0"
                            class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                            x-model="addQuota"
                            required
                        >
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button 
                        type="submit"
                        class="bg-abu-abu-keunguan text-biru-tua px-6 py-3 rounded-2xl hover:opacity-90 transition"
                    >
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: View Shift (Read-Only) -->
    <div 
    x-cloak
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        x-show="isViewOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
    >
        <div class="bg-biru-tua text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-lg relative">
            <!-- Close -->
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isViewOpen = false; selectedShift = null;"
            >
                &times;
            </button>
            <h2 class="text-3xl sm:text-4xl font-im-fell-english mb-4">
                View Shift
            </h2>
            <hr class="border-white/50 mb-6" />

            <template x-if="selectedShift">
                <div class="space-y-3 text-lg">
                    <p><strong>ID:</strong> <span x-text="selectedShift.id"></span></p>
                    <p><strong>Shift No.:</strong> <span x-text="selectedShift.shiftNo"></span></p>
                    <p><strong>Date:</strong> <span x-text="selectedShift.date"></span></p>
                    <p><strong>Time Start:</strong> <span x-text="selectedShift.timeStart"></span></p>
                    <p><strong>Time End:</strong> <span x-text="selectedShift.timeEnd"></span></p>
                    <p><strong>Initial Quota:</strong> <span x-text="selectedShift.kuota"></span></p>
                </div>
            </template>
        </div>
    </div>

    <!-- MODAL: Edit Shift (Form ke SHIFT UPDATE) -->
    <div 
    x-cloak
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        x-show="isEditOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
    >
        <div class="bg-biru-tua text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-lg relative">
            <!-- Close -->
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isEditOpen = false; selectedShift = null;"
            >
                &times;
            </button>
            <h2 class="text-3xl sm:text-4xl font-im-fell-english mb-4">
                Edit Shift
            </h2>
            <hr class="border-white/50 mb-6" />

            <template x-if="selectedShift">
                <!-- Form: submit ke route('admin.shift.update', selectedShift.id) -->
                <form 
                    :action="'{{ url('admin/shift') }}/' + selectedShift.id"
                    method="POST"
                >
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-biru-tua">
                        <!-- ID (readonly) -->
                        <div>
                            <label class="block text-xl mb-1 text-white">ID</label>
                            <input 
                                type="text"
                                class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                                :value="selectedShift.id"
                                readonly
                            >
                        </div>
                        <!-- Shift No. -->
                        <div>
                            <label class="block text-xl mb-1 text-white">Shift No.</label>
                            <input 
                                type="text"
                                name="shift_no"
                                class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                                x-model="selectedShift.shiftNo"
                                required
                            >
                        </div>
                        <!-- Date -->
                        <div>
                            <label class="block text-xl mb-1 text-white">Date</label>
                            <input 
                                type="date"
                                name="date"
                                class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                                x-model="selectedShift.date"
                                required
                            >
                        </div>
                        <!-- Time Start -->
                        <div>
                            <label class="block text-xl mb-1 text-white">Time Start</label>
                            <input 
                                type="time"
                                name="time_start"
                                class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                                x-model="selectedShift.timeStart"
                                required
                            >
                        </div>
                        <!-- Time End -->
                        <div>
                            <label class="block text-xl mb-1 text-white">Time End</label>
                            <input 
                                type="time"
                                name="time_end"
                                class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                                x-model="selectedShift.timeEnd"
                                required
                            >
                        </div>
                        <!-- Quota -->
                        <div>
                            <label class="block text-xl mb-1 text-white">Initial Quota</label>
                            <input 
                                type="number"
                                name="kuota"
                                min="0"
                                class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                                x-model="selectedShift.kuota"
                                required
                            >
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button 
                            type="submit"
                            class="bg-abu-abu-keunguan text-biru-tua px-6 py-3 rounded-2xl hover:opacity-90 transition"
                        >
                            Update
                        </button>
                    </div>
                </form>
            </template>
        </div>
    </div>

    <!-- MODAL: Confirm Delete (Form ke SHIFT DESTROY) -->
    <div 
    x-cloak
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        x-show="isDeleteOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
    >
        <div class="bg-biru-tua text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-md relative">
            <!-- Close -->
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isDeleteOpen = false; selectedShift = null;"
            >
                &times;
            </button>
            <h2 class="text-2xl sm:text-3xl font-im-fell-english mb-4">
                Are you sure?
            </h2>
            <hr class="border-white/50 mb-6" />

            <p class="mb-6">
                You are about to <span class="font-semibold text-red-300">delete</span> Shift 
                with ID: <span class="font-bold" x-text="selectedShift?.id"></span>. 
                This action cannot be undone.
            </p>

            <template x-if="selectedShift">
                <form 
                    :action="'{{ url('admin/shift') }}/' + selectedShift.id"
                    method="POST"
                >
                    @csrf
                    @method('DELETE')

                    <div class="flex justify-end gap-4">
                        <button
                            type="button"
                            class="bg-gray-300 text-biru-tua px-4 py-2 rounded-2xl hover:opacity-90 transition"
                            @click="isDeleteOpen = false; selectedShift = null;"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="bg-red-600 text-white px-4 py-2 rounded-2xl hover:opacity-90 transition"
                        >
                            Delete
                        </button>
                    </div>
                </form>
            </template>
        </div>
    </div>

    <!-- -----------------------------
         MODAL: Import Excel
         ----------------------------- -->
         <div x-cloak
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        x-show="isImportOpen"
        x-transition
    >
        <div class="bg-biru-tua text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-lg relative">
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isImportOpen = false; resetImport();"
            >
                &times;
            </button>

            <h2 class="text-3xl sm:text-4xl font-im-fell-english mb-4">
                Import Excel
            </h2>
            <hr class="border-white/50 mb-6" />

            <p class="text-xl sm:text-2xl mb-2">
                Format file:
            </p>
            <div class="bg-custom-gray rounded-2xl p-4 sm:p-6 mb-4 text-biru-tua">
            <p>ID, Shift_No, Date, Time_Start, Time_End, Quota</p>
            </div>

            <!-- Pilih File -->
            <p class="text-xl sm:text-2xl mb-2">Choose File</p>
            <label class="inline-block mb-4">
                <div 
                    class="bg-biru-tua border border-white py-2 px-4 
                            rounded-2xl cursor-pointer hover:opacity-90 inline-block"
                >
                    <span x-text="chosenFile ? chosenFile.name : 'No File Chosen'"></span>
                </div>
                <input 
                    type="file" 
                    class="hidden"
                    accept=".xlsx,.xls,.csv"
                    @change="chosenFile = $event.target.files[0]"
                >
            </label>

            <button 
                class="bg-abu-abu-keunguan text-biru-tua px-6 py-3 rounded-2xl hover:opacity-90 transition"
                @click="saveImport" :disabled="isLoading"
            >
                Import
            </button>
            <!-- Loading Indicator -->
            <div x-show="isLoading" class="loading">
                Importing... Time elapsed: <span x-text="elapsedTime"></span> seconds
            </div>
        </div>
    </div>

</div>
@endsection
