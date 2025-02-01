<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Shift</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        function manageShift() {
            return {
                shiftList: {!!$shifts->map(function($shift) {
                        return [
                            'shiftId' => $shift->id,
                            'shiftNo' => $shift->shift_no,
                            'date' => $shift->date,
                            'timeStart' => $shift->time_start,
                            'timeEnd' => $shift->time_end,
                            'kuota' => $shift->kuota - $shift->plottingans_count,
                        ];
                    }) -> toJson() !!},

                // Search & Pagination
                searchTerm: '',
                showEntries: 10,
                currentPage: 1,

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
            }
        }
    </script>
</head>

<body class="bg-Shift bg-cover bg-center bg-no-repeat max-w-full min-h-screen">
    @if(session('error') || session('success'))
        <x-notification />
    @endif

    <div class="bg-BlackLayer w-full h-full z-30 font-im-fell-english overflow-hidden">
        <div class="inset-0 text-white text-center mt-12">
            <h2 class="font-crimson-text text-lg lg:text-xl md:text-xl pb-1 font-bold">Discover the light within</h2>
            <h1 class="text-2xl md:text-3xl lg:text-3xl">Choose Your Shift</h1>
        </div>
        <!-- Tabel Shift -->
        <div x-data="manageShift()" x-init="console.log('Alpine Initialized:', $data)"
            class="bg-Table mx-auto my-5 w-[95%] h-full rounded-2xl text-shift text-xs lg:text-xl md:text-xl p-4 sm:p-6 md:p-8">
            <!-- Show Entries & Search -->
            <div class="flex m-5 justify-between h-5 lg:h-8 md:h-8">
                <!-- Show Entries -->
                <div class="flex space-x-2 items-center">
                    <p>Show</p>
                    <input
                        type="number"
                        x-model="showEntries"
                        min="1"
                        class="w-12 h-full text-center bg-white border-black border-[1px] rounded-full">
                    <p>Entries</p>
                </div>
                <input type="text" x-model="searchTerm" placeholder="Search" class="w-36 lg:w-60 md:w-60 h-full px-4 bg-white border-black border-[1px] rounded-full">
            </div>

            <!-- Table -->
            <div class="overflow-x-auto flex m-5 bg-white text-center">
                <table class="table-auto border-black border-[1px] w-full border-spacing-0">
                    <thead>
                        <tr class="h-10 lg:h-12 md:h-12">
                            <th class="border-[1px] border-black">No.</th>
                            <th class="border-[1px] border-black">Date</th>
                            <th class="border-[1px] border-black">Shift No.</th>
                            <th class="border-[1px] border-black">Time</th>
                            <th class="border-[1px] border-black">Quota</th>
                            <th class="border-[1px] border-black">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(shift, i) in paginatedData" :key="shift.shiftId">
                            <tr class="class="h-10 lg:h-14 md:h-14">
                                <!-- No -->
                                <td class="py-3 px-3 border-[1px] border-black">
                                    <span x-text="(currentPage - 1) * showEntries + i + 1"></span>.
                                </td>
                                <!-- Date -->
                                <td class="py-3 px-3 border-[1px] border-black"
                                    x-text="new Date(shift.date).toLocaleDateString('en-US', { weekday: 'long', day: '2-digit', month: 'long', year: 'numeric' })"></td>
                                <!-- Shift No -->
                                <td class="py-3 px-3 border-[1px] border-black" x-text="shift.shiftNo"></td>
                                <!-- Time -->
                                <td class="py-3 px-3 border-[1px] border-black">
                                    <span x-text="shift.timeStart.slice(0, 5) + '-' + shift.timeEnd.slice(0, 5)"></span>
                                </td>
                                <!-- Quota -->
                                <td class="py-3 px-3 border-[1px] border-black" x-text="shift.kuota"></td>
                                <!-- Action -->
                                <td class="py-3 px-3 border-[1px] border-black">
                                    <button @click="showShift(shift.shiftId)" class="bg-AddButton px-1.5 py-1 text-center rounded-lg">
                                        <p class="text-white">Choose</p>
                                    </button>
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
                    @click="prevPage">
                    Previous
                </button>
                <template x-for="page in totalPages" :key="page">
                    <button
                        class="px-2 py-1 border rounded"
                        :class="currentPage === page ? 'bg-biru-tua text-white' : ''"
                        @click="goToPage(page)"
                        x-text="page"></button>
                </template>
                <button
                    class="px-2 py-1 border rounded disabled:opacity-50"
                    :disabled="currentPage >= totalPages"
                    @click="nextPage">
                    Next
                </button>
            </div>
        </div>
    </div>
    <x-confirm-shift />
    <x-sidebar />
    <x-home-button />
</body>

</html>