<!-- resources/views/admin/layouts/app2.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Crystal Cavern')</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    @vite('resources/css/app.css')
    
    <!-- Alpine.js untuk toggle sidebar dan dropdown -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body
    x-data="{ open: false, isProfileOpen: false }"
    class="relative min-h-screen"
>
<canvas id="webgl-canvas" class="absolute w-screen h-screen top-0 -z-10"></canvas>
    {{-- HEADER (fixed) --}}
    <x-admin-nav/>

    <!-- WRAPPER UTAMA: agar footer 'sticky' -->
<div class="pt-20 md:pt-24 flex flex-col min-h-screen">
    {{-- MAIN CONTENT (flex-grow) --}}
    <main class="flex-grow flex flex-col items-center justify-center px-4">
        @yield('content')
    </main>

    {{-- FOOTER (posisi di bawah, atau 'sticky' ketika konten sedikit) --}}
    <footer
    class="w-full h-20 md:h-24 bg-gray-300 flex items-center justify-center px-2"
>
    <p
        class="text-biru-tua text-base sm:text-lg md:text-xl lg:text-2xl font-im-fell-english text-center"
    >
        ©Crystal Cavern. DLOR 2025. All Rights Reserved.
    </p>
</footer>
</div>
<x-admin-background/>
    @stack('scripts')
</body>
</html>
