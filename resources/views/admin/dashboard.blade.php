<!-- resources/views/admin/dashboard.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Dashboard - Crystal Cavern')

@section('content')
<div 
    class="w-full max-w-7xl mx-auto px-4 py-6"
    x-data="{
        announcement: @json($announcement),
        shift: @json($shift),
        gems: @json($gems),

        // State default
        state: '{{ $current_state }}',

        // Search data
        searchTerm: '',
        allItems: [
            'Administration', 
            'Coding & Writing Test', 
            'Interview', 
            'Grouping Task', 
            'Teaching Test', 
            'Upgrading'
        ],

        // Method (getter) untuk filtering item
        get filteredItems() {
            if (!this.searchTerm) return this.allItems;
            // Return item yang mengandung searchTerm
            return this.allItems.filter(item => 
                item.toLowerCase().includes(this.searchTerm.toLowerCase())
            )
        },
        async updateState(a, sh, g, st) {
            try {
                const response = await fetch('{{ route('admin.dashboard.update', ['dashboard'=>1]) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        _method: 'patch',
                        pengumuman_on : a,
                        isi_jadwal_on : sh,
                        role_on : g,
                        current_stage : st,
                    }),
                });

                if (!response.ok) {
                    throw new Error('Failed to update state');
                }
            } catch (error) {
                console.error(error);
                alert('An error occurred while updating the state.');
            }
        },
    }"
>

    <!-- Status Card -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-white bg-biru-tua rounded-2xl p-6">
        <!-- Welcome Section -->
        <div class="text-center space-y-2">
            <p class="text-base sm:text-lg md:text-2xl font-im-fell-english">
                Welcome back,
            </p>
            <p class="text-2xl sm:text-3xl md:text-4xl font-im-fell-english">
                {{ Auth::user()->nim }}
            </p>
        </div>
        
        <!-- State Section -->
        <div class="text-center space-y-2">
            <p class="text-base sm:text-lg md:text-2xl font-im-fell-english">State</p>
            <!-- Menampilkan state yang dinamis -->
            <p 
                class="text-2xl sm:text-3xl md:text-4xl font-im-fell-english" 
                x-text="state"
                ></p>
            </div>
            
        
        <!-- Announcement Section -->
        <div class="text-center space-y-2">
            <p class="text-base sm:text-lg md:text-2xl font-im-fell-english">
                Announcement
            </p>
            <p 
                class="text-2xl sm:text-3xl md:text-4xl font-im-fell-english"
                x-text="announcement ? 'ON' : 'OFF'"
            ></p>
        </div>
        
        <!-- Choose Shift Section -->
        <div class="text-center space-y-2">
            <p class="text-base sm:text-lg md:text-2xl font-im-fell-english">
                Choose Shift
            </p>
            <p 
                class="text-2xl sm:text-3xl md:text-4xl font-im-fell-english"
                x-text="shift ? 'ON' : 'OFF'"
            ></p>
        </div>
        
        <!-- Choose Gems Section -->
        <div class="text-center space-y-2">
            <p class="text-base sm:text-lg md:text-2xl font-im-fell-english">
                Choose Gems
            </p>
            <p
                class="text-2xl sm:text-3xl md:text-4xl font-im-fell-english"
                x-text="gems ? 'ON' : 'OFF'"
            ></p>
        </div>
    </div>
    
    <!-- Configuration Section -->
    <div class="mt-10 bg-abu-abu4 rounded-3xl p-6 space-y-6 shadow-md">
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-6">
                <h2 
                    class="text-3xl sm:text-4xl md:text-5xl font-[IM_FELL_Double_Pica] 
                           text-biru-tua3 text-center md:text-left"
                >
                    Configuration
                </h2>

                <!-- Configuration Options -->
                <div class="space-y-4">
                    <!-- Announcement Toggle -->
                    <div 
                        class="flex items-center justify-between bg-putih rounded-full p-3 
                               cursor-pointer hover:shadow-lg transition-all"
                        @click="
                            announcement = !announcement;
                            updateState(announcement, shift, gems, state);
                        "
                    >
                        <span 
                            class="text-lg sm:text-xl md:text-2xl font-crimson text-biru-tua"
                        >
                            Announcement
                        </span>
                        <div 
                            class="relative w-24 h-12 rounded-full" 
                            :class="announcement ? 'bg-green-500' : 'bg-gray-300'"
                            style="transition: background-color 0.3s ease;"
                        >
                            <div 
                                class="absolute top-1 w-10 h-10 bg-white rounded-full shadow-md"
                                :class="announcement ? 'right-1' : 'left-1'"
                                style="transition: all 0.3s ease;"
                            ></div>
                        </div>
                    </div>

                    <!-- Choose Shift Toggle -->
                    <div 
                        class="flex items-center justify-between bg-putih rounded-full p-3 
                               cursor-pointer hover:shadow-lg transition-all"
                        @click="
                            shift = !shift;
                            updateState(announcement, shift, gems, state);
                        "
                    >
                        <span 
                            class="text-lg sm:text-xl md:text-2xl font-crimson text-biru-tua"
                        >
                            Choose Shift
                        </span>
                        <div 
                            class="relative w-24 h-12 rounded-full"
                            :class="shift ? 'bg-green-500' : 'bg-gray-300'"
                            style="transition: background-color 0.3s ease;"
                        >
                            <div 
                                class="absolute top-1 w-10 h-10 bg-white rounded-full shadow-md"
                                :class="shift ? 'right-1' : 'left-1'"
                                style="transition: all 0.3s ease;"
                            ></div>
                        </div>
                    </div>

                    <!-- Choose Gems Toggle -->
                    <div 
                        class="flex items-center justify-between bg-putih rounded-full p-3 
                               cursor-pointer hover:shadow-lg transition-all"
                        @click="
                            gems = !gems;
                            updateState(announcement, shift, gems, state);
                        "
                    >
                        <span 
                            class="text-lg sm:text-xl md:text-2xl font-crimson text-biru-tua"
                        >
                            Choose Gems
                        </span>
                        <div 
                            class="relative w-24 h-12 rounded-full"
                            :class="gems ? 'bg-green-500' : 'bg-gray-300'"
                            style="transition: background-color 0.3s ease;"
                        >
                            <div 
                                class="absolute top-1 w-10 h-10 bg-white rounded-full shadow-md"
                                :class="gems ? 'right-1' : 'left-1'"
                                style="transition: all 0.3s ease;"
                            ></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column (Search Configuration) -->
            <div class="space-y-4">
                <h2 
                    class="text-3xl sm:text-4xl md:text-5xl font-[IM_FELL_Double_Pica] 
                           text-biru-tua3 text-center md:text-left"
                >
                    State
                </h2>
                <!-- Input Search -->
                <div class="relative">
                    <input 
                        type="text" 
                        placeholder="Search configuration..."
                        class="w-full h-12 pl-6 pr-12 rounded-full border border-biru-tua 
                               bg-custom-gray focus:outline-none focus:ring-2 focus:ring-biru-tua"
                        x-model="searchTerm"
                    >
                    <!-- Icon Search -->
                    <svg 
                        class="w-6 h-6 absolute right-4 top-3" 
                        viewBox="0 0 24 24" 
                        fill="none" 
                        stroke="#303030" 
                        stroke-width="2"
                    >
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </div>

                <!-- Search Results -->
                <div 
                    class="bg-custom-gray/50 p-4 rounded-lg space-y-3"
                    x-show="filteredItems.length > 0"
                    x-transition
                >
                    <!-- Loop item hasil pencarian -->
                    <template x-for="(item, index) in filteredItems" :key="index">
                        <div 
                            class="text-xl sm:text-2xl font-crimson text-biru-tua text-center 
                                   hover:bg-white hover:rounded-md py-1 transition cursor-pointer"
                            :class="{'font-bold': item === state}"
                            x-text="item"
                            @click="
                                // Klik item => ubah state
                                state = item;
                                // Bersihkan searchTerm setelah memilih item
                                searchTerm = '';
                                updateState(announcement, shift, gems, state);
                            "
                        ></div>
                    </template>
                </div>
            </div>
        </div> 
    </div>
</div>
@endsection
