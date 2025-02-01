{{-- resources/views/admin/gems-detail.blade.php --}}

@extends('admin.layouts.app')

@section('title', "Gem Detail - $role->name")

@section('content')
<div class="w-full max-w-screen-2xl mx-auto px-4 sm:px-6 md:px-8 py-6 text-white">

    <!-- Judul -->
    <h1 class="text-center text-3xl sm:text-4xl md:text-5xl font-im-fell-english">
        Detail Gem: {{ $role->name }}
    </h1>

    <!-- Card Detail Gem -->
    <div class="mt-8 bg-abu-abu-keunguan rounded-2xl p-6 sm:p-8 flex flex-col sm:flex-row">
        <!-- Gambar Gem -->
        <div class="flex-shrink-0 mb-4 sm:mb-0 sm:mr-6">
            @if($role->image)
                <img 
                    src="{{ $role->image }}" 
                    alt="Gem Image" 
                    class="h-32 w-32 object-cover rounded-md border"
                >
            @else
                <div class="h-32 w-32 flex items-center justify-center bg-black/20 text-gray-300 italic">
                    No Image
                </div>
            @endif
        </div>
        <!-- Info Gem -->
        <div class="flex-grow">
            <p class="text-biru-tua text-xl sm:text-2xl font-im-fell-english mb-2">
                Quota: 
                <span class="text-white font-semibold">{{ $role->quota }}</span>
            </p>
            <p class="text-biru-tua text-xl sm:text-2xl font-im-fell-english mb-2">
                Description:
            </p>
            <p class="text-white text-sm sm:text-base">
                {{ $role->description ?? '-' }}
            </p>
        </div>
    </div>

    <!-- List CAAS -->
    <div class="mt-8 bg-custom-gray rounded-2xl p-4 sm:p-6 md:p-8">
        <h2 class="text-biru-tua text-2xl sm:text-3xl font-im-fell-english mb-4">
            CAAS Who Picked This Gem
        </h2>

        @if($caasList->isEmpty())
            <p class="text-red-800 italic">
                No one has chosen this gem yet.
            </p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full border border-black rounded-md overflow-hidden table-auto bg-white">
                    <thead class="bg-abu-abu-keunguan">
                        <tr class="border-b border-black text-biru-tua font-im-fell-english">
                            <th class="py-3 px-3 border-r border-black">No.</th>
                            <th class="py-3 px-3 border-r border-black">NIM</th>
                            <th class="py-3 px-3 border-r border-black">Name</th>
                            <th class="py-3 px-3 border-r border-black">Email</th>
                            <th class="py-3 px-3 border-r border-black">Major</th>
                            <th class="py-3 px-3">Class</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($caasList as $index => $caas)
                            <tr class="border-b border-black last:border-b-0 text-biru-tua">
                                <td class="py-3 px-3 border-r border-black">
                                    {{ $index + 1 }}.
                                </td>
                                <td class="py-3 px-3 border-r border-black">
                                    {{ $caas['nim'] }}
                                </td>
                                <td class="py-3 px-3 border-r border-black">
                                    {{ $caas['name'] }}
                                </td>
                                <td class="py-3 px-3 border-r border-black">
                                    {{ $caas['email'] }}
                                </td>
                                <td class="py-3 px-3 border-r border-black">
                                    {{ $caas['major'] }}
                                </td>
                                <td class="py-3 px-3">
                                    {{ $caas['className'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Back Button -->
    <div class="mt-6">
        <a 
            href="{{ route('admin.gems') }}" 
            class="bg-biru-tua text-white px-4 py-2 rounded-lg hover:opacity-90 transition"
        >
            Back to Manage Gems
        </a>
    </div>
</div>
@endsection
