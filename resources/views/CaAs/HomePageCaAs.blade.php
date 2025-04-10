<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DLOR 2025</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
</head>

<body
    class="font-im-fell-english min-h-screen bg-HomePageCaAs bg-cover bg-center bg-no-repeat max-w-full overflow-x-hidden">
    <canvas id="webgl-canvas" class="absolute w-screen h-screen top-0 z-0"></canvas>


    <!-- Background Image -->
    <div class="fixed top-0 h-full grid place-items-center z-10 sm:hidden ">
        <img src="assets/Light.webp" alt="upper shine light" class="h-full w-auto opacity-80 ">
    </div>

    <img src="assets/Wall2.webp" alt="left wall" class="fixed z-30 -left-24 h-[55%] sm:h-[90%] w-auto">

    <div class="fixed inset-0 grid place-items-center z-20 ">
        <img src="assets/Dust.webp" alt="bats" class="h-auto w-full sm:hidden opacity-80">
    </div>

    <img src="assets/Wall2.webp" alt="right wall"
        class="fixed z-30 -right-32 h-full w-full sm:w-auto scale-x-[-1] scale-y-[-1]">

    <img src="assets/Crystal 1.webp" alt="bottom left crystal" class="fixed bottom-0 z-40 left-0 h-52 sm:h-96 w-auto">

    <img src="assets/Crystal 3.webp" alt="top right crystal" class="fixed top-0 z-40 right-0 h-96 w-auto">

    <img src="assets/Bats.webp" alt="bats" class="fixed top-0 z-40 left-0 h-52 sm:h-96 w-auto">

    <img src="assets/Shine.webp" alt="shine" class="fixed bottom-20 z-40 left-0 h-auto w-[70px] sm:w-auto pulsing">

    <img src="assets/Shine.webp" alt="shine"
        class="fixed bottom-0 z-40 left-24 sm:left-40 h-auto w-[70px] sm:w-auto pulsing">
    <img src="assets/Star 1.webp" alt="star" class="fixed bottom-0 z-40 right-0  h-auto w-auto pulsing">
    <img src="assets/Star 2.webp" alt="star" class="fixed bottom-0 z-40 right-0  h-auto w-auto pulsing">

    <div class="absolute inset-0 flex flex-col items-center justify-center z-40 text-center px-4">
        <h1 class="text-white font-normal text-3xl md:text-5xl sm:text-3xl" id="typewriter"></h1>
        <p class="text-white py-2 text-lg font-bold leading-[32px] font-crimson-text md:text-xl md:leading-[24px] sm:text-sm sm:leading-[20px] fade-up"
            style="animation-delay: 3.2s">Discover The Light Within</p>
    </div>

    <x-sidebar></x-sidebar>


</body>

</html>
