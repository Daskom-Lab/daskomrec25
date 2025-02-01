<!-- resources/views/components/admin-nav.blade.php -->

<header
    class="fixed top-0 left-0 w-full bg-gray-300 h-20 md:h-22 z-40 flex items-center">
    <div class="flex justify-between w-full px-2 sm:px-4 md:px-6">
        <!-- Kiri: Hamburger + Brand -->
        <div class="flex items-center space-x-3">
            <button
                class="p-2 flex flex-col space-y-1 sm:space-y-2"
                @click="open = !open">
                <span class="block w-8 h-1 bg-biru-tua rounded-lg sm:w-12 sm:h-2"></span>
                <span class="block w-8 h-1 bg-biru-tua rounded-lg sm:w-12 sm:h-2"></span>
                <span class="block w-8 h-1 bg-biru-tua rounded-lg sm:w-12 sm:h-2"></span>
            </button>

            <h1 class="text-biru-tua text-xl sm:text-2xl md:text-2xl lg:text-4xl font-im-fell-english">
                DLOR 2025
            </h1>
        </div>

        <!-- Kanan: Profile + Username -->
        <div class="relative flex items-center space-x-2 sm:space-x-3 md:space-x-4">
            <button
                @click="isProfileOpen = !isProfileOpen"
                class="w-12 h-12 md:w-16 md:h-16 rounded-full bg-white flex items-center justify-center border-2 border-biru-tua focus:outline-none hover:scale-105 transition-transform"
                aria-label="Open Profile Menu">
                {{-- SVG Profil --}}
                <svg
                    width="28"
                    height="28"
                    class="md:w-10 md:h-10"
                    viewBox="0 0 43 43"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M29.25 10.0638C29.25 14.215 25.7531 17.9217 21.5 17.9217C17.2469 17.9217 13.75 14.215 13.75 10.0638C13.75 5.86479 17.2922 1.875 21.5 1.875C25.7078 1.875 29.25 5.86479 29.25 10.0638ZM41.125 32.4493C41.125 34.6517 39.8655 36.7759 36.7409 38.4045C33.5833 40.0504 28.6099 41.1254 21.5 41.1254C14.3901 41.1254 9.4167 40.0504 6.25909 38.4045C3.13453 36.7759 1.875 34.6517 1.875 32.4493C1.875 30.3938 3.68919 28.2257 7.34065 26.5126C10.9127 24.8368 15.9177 23.7733 21.5 23.7733C27.0823 23.7733 32.0873 24.8368 35.6594 26.5126C39.3108 28.2257 41.125 30.3938 41.125 32.4493Z"
                        stroke="#1A2254"
                        stroke-width="2" />
                </svg>
            </button>

            <span class="hidden sm:block text-biru-tua text-lg sm:text-xl md:text-2xl lg:text-3xl font-im-fell-english">
                {{ Auth::user()->nim }}
            </span>

            <!-- Dropdown menu -->
            <div
                x-cloak
                class="absolute top-16 md:top-22 right-0 w-48 sm:w-56 bg-gray-300/90 rounded-lg shadow-xl p-3 sm:p-4 z-40"
                x-show="isProfileOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                @click.outside="isProfileOpen = false">
                <a
                    href="{{ route('admin.reset-password') }}"
                    class="block w-full text-biru-tua text-base sm:text-lg md:text-xl font-im-fell-english mb-2 hover:underline transition-all text-center">
                    Change Password
                </a>
                <form 
                    id="logout-form" 
                    action="{{ route('admin.logout') }}" 
                    method="POST" 
                    class="block w-full"
                >
                    @csrf
                    <button 
                        type="submit" 
                        class="w-full text-biru-tua text-base sm:text-lg md:text-xl font-im-fell-english hover:underline transition-all text-center"
                    >
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

@php
    $navItems = [
        'Home' => route('admin.home'),
        'Dashboard' => route('admin.dashboard'),
        'Announcement' => route('admin.announcement'),
        'Manage CaAs' => route('admin.caas'),
        'Manage Asisten' => route('admin.asisten'),
        'Manage Gems' => route('admin.gems'),
        'Manage Shift' => route('admin.shift'),
        'View Plots' => route('admin.view-plot'),
    ];
@endphp

{{-- SIDEBAR (fixed) --}}
<aside
    x-cloak
    class="fixed top-20 md:top-26 left-0 w-48 sm:w-56 md:w-64 h-full bg-black/40 z-40 transform transition-transform duration-300 backdrop-blur-sm"
    :class="open ? 'translate-x-0' : '-translate-x-full'">
    <nav class="py-6 md:py-8 flex flex-col space-y-4 md:space-y-6">
        @foreach($navItems as $label => $url)
        <a href="{{ $url }}"
            class="text-left px-4 py-2 text-white text-base sm:text-lg md:text-xl lg:text-2xl font-im-fell-english
                       hover:bg-white/10 transition-colors duration-200">
            {{ $label }}
        </a>
        @endforeach
    </nav>
</aside>
