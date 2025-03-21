@extends('admin.layouts.app')

@section('title', 'Shift Detail - Crystal Cavern')

@section('content')
<div class="container mx-auto py-6 px-4 sm:px-6 md:px-8 text-white">
    <!-- Judul -->
    <h1 class="text-3xl sm:text-4xl font-im-fell-english mb-6">
        Shift #{{ $shift->id }} Detail
    </h1>

    <!-- Info SHIFT -->
    <div class="bg-biru-tua rounded-2xl p-4 sm:p-6 mb-6 shadow-md">
        <p><strong>Shift:</strong> {{ $shift->shift_no }}</p>
        <p><strong>Date:</strong> {{ $shift->date }}</p>
        <p><strong>Time:</strong> {{ $shift->time_start }} - {{ $shift->time_end }}</p>
        <p><strong>Quota:</strong> {{ $shift->kuota }}</p>
    </div>

    <!-- Judul Tabel -->
    <h2 class="text-2xl sm:text-3xl font-im-fell-english mb-4">
        CAAS Who Picked This Shift
    </h2>

    <!-- Search Field -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 gap-3">
        <!-- Search Input -->
        <div class="flex items-center space-x-2 w-full sm:w-96">
            <label 
            for="caasSearch" 
            class="text-biru-tua text-base sm:text-lg font-im-fell-english whitespace-nowrap"
        >
            Search CAAS:
        </label>
        <input 
            type="text"
            id="searchInput"
            class="bg-white border border-biru-tua rounded-[30px] px-4 py-2 
                   focus:outline-none focus:ring-2 focus:ring-biru-tua text-black
                   w-full text-sm sm:text-base"
            placeholder="Search CAAS (by NIM, Name, etc.)"
            onkeyup="searchTable()"
        >
        </div>
    </div>
    
    <!-- Table CAAS -->
    <div class="bg-custom-gray rounded-2xl p-4 sm:p-6 shadow-md overflow-x-auto">
        <table id="caasTable" class="min-w-full border border-black rounded-md overflow-hidden table-auto">
            <!-- Table Head -->
            <thead class="bg-white">
                <tr class="border-b border-black">
                    <th class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base md:text-lg text-center">No.</th>
                    <th class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base md:text-lg text-center">NIM</th>
                    <th class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base md:text-lg text-center">Name</th>
                    <th class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base md:text-lg text-center">Email</th>
                    <th class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base md:text-lg text-center">Major</th>
                    <th class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base md:text-lg text-center">Class</th>
                    <th class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base md:text-lg text-center">Gems</th>
                    <th class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base md:text-lg text-center">Status</th>
                    <th class="py-3 px-3 border-r border-black text-biru-tua font-im-fell-english text-sm sm:text-base md:text-lg text-center">State</th>
                    <th class="py-3 px-3 text-biru-tua font-im-fell-english text-sm sm:text-base md:text-lg text-center">Action</th>
                </tr>
            </thead>
            <!-- Table Body -->
            <tbody class="bg-white">
                @forelse($shift->plottingans as $index => $plot)
                    @php
                        $caas = $plot->caas;
                    @endphp
                    <tr class="border-b border-black last:border-b-0">
                        <!-- No -->
                        <td class="py-3 px-3 border-r border-black text-biru-tua text-center">
                            {{ $index + 1 }}.
                        </td>
                        <!-- NIM -->
                        <td class="py-3 px-3 border-r border-black text-biru-tua text-center">
                            {{ $caas->user->nim ?? '-' }}
                        </td>
                        <!-- Name -->
                        <td class="py-3 px-3 border-r border-black text-biru-tua text-center">
                            {{ $caas->user->profile->name ?? 'Unknown CAAS Name' }}
                        </td>
                        <!-- Email -->
                        <td class="py-3 px-3 border-r border-black text-biru-tua text-center">
                            {{ $caas->user->profile->email ?? '-' }}
                        </td>
                        <!-- Major -->
                        <td class="py-3 px-3 border-r border-black text-biru-tua text-center">
                            {{ $caas->user->profile->major ?? '-' }}
                        </td>
                        <!-- Class -->
                        <td class="py-3 px-3 border-r border-black text-biru-tua text-center">
                            {{ $caas->user->profile->class ?? 'N/A' }}
                        </td>
                        <!-- Gems -->
                        <td class="py-3 px-3 border-r border-black text-biru-tua text-center">
                            {{ $caas->role->name ?? 'No Gem' }}
                        </td>
                        <!-- Status -->
                        <td class="py-3 px-3 border-r border-black text-center
                            {{ strtolower($caas->user->caasStage->status ?? '') === 'pass' ? 'text-green-600 font-semibold' : '' }}
                            {{ strtolower($caas->user->caasStage->status ?? '') === 'fail' ? 'text-red-600 font-semibold' : '' }}
                            {{ !in_array(strtolower($caas->user->caasStage->status ?? ''), ['pass', 'fail']) ? 'text-biru-tua' : '' }}"
                        >
                            {{ $caas->user->caasStage->status ?? 'Unknown' }}
                        </td>
                        <!-- State -->
                        <td class="py-3 px-3 border-r border-black text-biru-tua text-center">
                            {{ $caas->user->caasStage->stage->name ?? '-' }}
                        </td>
                        <!-- Action -->
                        <td class="py-3 px-3 text-center">
                            <form action="{{ route('admin.plottingan.delete', $plot->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal CAAS ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:opacity-90 transition text-sm">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <!-- Jika tidak ada CAAS sama sekali -->
                    <tr>
                        <td colspan="10" class="py-3 px-3 text-center text-biru-tua">
                            No CAAS assigned yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Tombol Back -->
    <div class="mt-6">
        <a 
            href="{{ route('admin.view-plot') }}" 
            class="inline-block bg-biru-tua text-white px-4 py-2 rounded hover:opacity-90 hover:shadow-md transition"
        >
            Back to View Plot
        </a>
    </div>
</div>

<script>
    function searchTable() {
        const input = document.getElementById("searchInput");
        const filter = input.value.toLowerCase();
        const rows = document.querySelectorAll("#caasTable tbody tr");
        rows.forEach(row => {
            if (row.innerText.toLowerCase().includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }
</script>

@endsection
