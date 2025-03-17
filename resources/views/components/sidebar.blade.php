<!-- Hamburger Button -->
<button id="sidebarToggle" type="button"
    class="fixed top-0 left-0 inline-flex items-center h-fit z-50 hover:scale-105 hover:brightness-150 active:scale-95">
    <img src="assets/Sidebar.webp" class="h-[50px] lg:h-[70px] md:h-[60px] sm:h-[55px]" alt="hamburger">
</button>

<!-- Sidebar -->
<aside id="default-sidebar"
    class="fixed top-0 left-0 z-40 w-[50%] md:w-[20%] lg:w-[20%] h-screen bg-black bg-opacity-50 transition-transform -translate-x-full"
    aria-label="Sidebar">
    <div class="h-full px-3 overflow-y-auto opacity-90 scrollbar-hidden">
        <h1 class="text-white text-center text-2xl mb-2 mt-8 font-im-fell-english font-semibold">Account</h1>
        <ul class="space-y-1 font-medium">
            <li class="h-16 max-w-[232px] mx-auto">
                <a href="/profile" class="flex items-center justify-center p-2 text-gray-200 rounded-lg h-full">
                    <x-sidebar-button>Profile</x-sidebar-button>
                </a>
            </li>
            <li class="h-16 max-w-[232px] mx-auto">
                <a href="/change-password" class="flex items-center justify-center p-2 text-gray-200 rounded-lg h-full">
                    <x-sidebar-button>Change Password</x-sidebar-button>
                </a>
            </li>
        </ul>
        @php
            use Illuminate\Support\Facades\Auth;
            $config = App\Models\Configuration::find(1);
            $user = Auth::user();
        @endphp

        <!-- Recruitment Section -->        
        @if ($config && $config->pengumuman_on || 
            ($config && ($config->isi_jadwal_on || $config->role_on) && $user->caasStage->status !== "Fail"))
            <h1 class="text-white text-center text-2xl mt-4 mb-2 font-im-fell-english font-semibold">Recruitment</h1>
        @endif

        <ul class="space-y-1 font-medium">
            {{-- Announcement Link --}}
            @if ($config && $config->pengumuman_on)
                <li class="h-16 max-w-[232px] mx-auto">
                    <a href="/announcement"
                        class="flex items-center justify-center p-2 text-gray-200 rounded-lg h-full">

                        <x-sidebar-button>Announcement</x-sidebar-button>
                    </a>
                </li>
            @endif

            {{-- Choose Shift Link (hide if user FAIL) --}}
            @if ($config && $config->isi_jadwal_on && $user->caasStage && $user->caasStage->status !== 'Fail')
                <li class="h-16 max-w-[232px] mx-auto">
                    <a href="/choose-shift"
                        class="flex items-center justify-center p-2 text-gray-200 rounded-lg h-full">
                        <x-sidebar-button>Shift</x-sidebar-button>
                    </a>
                </li>
            @endif

            {{-- Choose Gems Link (hide if user FAIL) --}}
            @if ($config && $config->role_on && $user->caasStage && $user->caasStage->status !== 'Fail')
                <li class="h-16 max-w-[232px] mx-auto">
                    <a href="/choose-gem" class="flex items-center justify-center p-2 text-gray-200 rounded-lg h-full">
                        <x-sidebar-button>Gems</x-sidebar-button>
                    </a>
                </li>
            @endif
        </ul>
        <h1 class="text-white text-center text-2xl mt-4 mb-2 font-im-fell-english font-semibold">Contacts</h1>
        <ul class="space-y-1 font-medium">
            <li class="h-16 max-w-[232px] mx-auto">
                <a href="/assistants" class="flex items-center justify-center p-2 text-gray-200 rounded-lg h-full">
                    <x-sidebar-button>Assistant</x-sidebar-button>
                </a>
            </li>
            <li class="h-16 max-w-[232px] mx-auto">
                <a href="https://linevoom.line.me/user/_ddC3_yWIwlwYuNBiu5bze2jCQEs_wJusB73Pssk" target="_blank"
                    rel="noopener noreferrer"
                    class="flex items-center justify-center p-2 text-gray-200 rounded-lg h-full">
                    <x-sidebar-button>OA Line</x-sidebar-button>
                </a>
            </li>
        </ul>
        <ul class="h-16 max-w-[232px] mx-auto">
            <form id="logout-form" action="{{ route('caas.logout') }}" method="POST"
                class="flex items-center justify-center p-2 text-gray-200 rounded-lg h-full">
                @csrf <!-- CSRF token for security -->
                <button type="submit"
                    class="w-full h-full py-10 rounded-lg text-primary text-base sm:text-xl font-bold font-crimson-text relative overflow-hidden transition-all duration-300 ease-in-out transform hover:scale-105 active:scale-95">
                    <img src="assets/Button Ungu.webp" alt="button" class="w-full h-full absolute inset-0 -z-10">
                    <span class="absolute inset-0 flex justify-center items-center text-center">
                        Log Out
                    </span>
                </button>
            </form>
        </ul>
    </div>
</aside>


<!-- JavaScript -->
<script>
    // Select the toggle button and sidebar
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('default-sidebar');

    // Add event listener to toggle sidebar visibility
    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
    });

    // Close the sidebar when clicking outside of it
    document.addEventListener('click', (e) => {
        // Check if the click is outside the sidebar and the sidebar toggle button
        if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
            sidebar.classList.add('-translate-x-full');
        }
    });
</script>
