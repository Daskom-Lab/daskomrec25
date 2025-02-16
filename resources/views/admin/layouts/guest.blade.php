<!-- resources/views/admin/layouts/guest.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal - @yield('title')</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    @vite('resources/css/app.css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
</head>
<body class="font-im-fell-english flex flex-col min-h-screen">
    <canvas id="webgl-canvas" class="absolute w-screen h-screen top-0 -z-10"></canvas>

    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="w-full bg-footer-gray py-6 mt-auto">
        <p class="mx-auto text-center text-text-color font-im-fell-english 
                   text-xl sm:text-lg md:text-xl lg:text-2xl">
            ©Crystal Cavern. DLOR 2025. All Rights Reserved.
        </p>
    </footer>
    <x-admin-background/>
</body>
</html>
