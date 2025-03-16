<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assistants Page</title>

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="preload" href="{{ asset('assets/Wall2.webp') }}" as="image">
    <link rel="preload" href="{{ asset('assets/Crystal 3.webp') }}" as="image">
    <link rel="preload" href="{{ asset('assets/Light.webp') }}" as="image">
    @for ($i = 1; $i <= 87; $i++)
        <link rel="preload" href="{{ asset("assets/profilasisten/Asisten ($i).webp") }}" as="image">
    @endfor
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script defer src="{{ asset('js/slider2.js') }}"></script>
</head>

<body
    class="bg-AssistantsPage bg-cover bg-fixed bg-no-repeat min-h-screen max-w-full scroll-x-hide text-white overflow-hidden">

    <!-- Background Image -->
    <img src="assets/Wall2.webp" alt="Wall" class="fixed left-0 h-full w-auto">
    <img src="assets/Wall-Mobile.webp" alt="Wall" class="fixed inset-0 w-[200px] sm:hidden">
    <img src="assets/Crystal 3.webp" alt="Crystal" class="fixed bottom-0 left-0 h-96 w-auto scale-x-[-1] scale-y-[-1]">
    <img src="assets/Crystal 5.webp" alt="Crystal" class="fixed bottom-0 z-10 left-36 h-52 w-auto">
    <img src="assets/Crystal 2.webp" alt="Crystal" class="fixed top-0 z-10 left-0 h-full w-auto">
    <img src="assets/Shine.webp" alt="Shine" class="fixed bottom-24 z-10 left-5 h-auto w-[70px] sm:w-auto">
    <img src="assets/Shine.webp" alt="Shine" class="fixed bottom-10 z-10 left-32  h-auto w-[70px] sm:w-auto">
    <img src="assets/Wall 3.webp" alt="Wall"
        class="fixed right-0 h-full w-auto opacity-0 lg:opacity-100 md:opacity-100">
    <div class="fixed inset-0 grid place-items-center -z-10">
        <img src="assets/Light.webp" alt="Upper Shine" class="h-full w-auto opacity-40">
    </div>
    <img src="assets/Crystal 5.webp" alt="Crystal"
        class="fixed bottom-0 -right-14 h-60 w-auto opacity-0 lg:opacity-100 md:opacity-100">
    <img src="assets/Shine.webp" alt="Shine"
        class="fixed bottom-10 right-5 w-[200px] opacity-0 lg:opacity-100 md:opacity-100">

    <div class="absolute flex items-center justify-center bg-BlackLayer bg-opacity-50 w-full h-full z-20">
        <div class="container max-w-full sm:max-w-[80%] md:max-w-[90%] lg:max-w-[70%] mx-auto font-im-fell-english">
            <div class="relative justify-center">
                <div class="text-center h-sm:translate-y-5">
                    <h1 class="text-2xl font-crimson-text pb-2">Daskom Laboratory</h1>
                    <h1 class="text-4xl">Assistants 2025</h1>
                </div>
                <div class="owl-carousel owl-theme justify-evenly mx-auto mb-8" id="carouselContainer">
                    <div class="relative w-[380px] mx-auto -translate-y-14 sm:-translate-x-12 md:translate-x-0" id="firstCard">
                        <img src="{{ asset('assets/profilasisten/Asisten (1).webp') }}" alt="Assistant"
                            class="w-[200px]">
                    </div>
                    @for ($i = 2; $i <= 87; $i++)
                        <div class="relative w-[380px] mx-auto sm:-translate-x-12 md:translate-x-0">
                            <img src="{{ asset("assets/profilasisten/Asisten ($i).webp") }}" alt="Assistant"
                                class="w-[200px]">
                        </div>
                    @endfor
                </div>
                <div class="flex justify-center h-[60px]">
                    <button class="owl-prev py-1 hover:scale-105 hover:brightness-110 active:scale-95" type="button">
                        <img src="assets/Prev.webp" alt="Prev" class="h-[60px]">
                    </button>
                    <button class="owl-next py-1 hover:scale-105 hover:brightness-110 active:scale-95" type="button"
                        onclick="moveCardDown()">
                        <img src="assets/Next.webp" alt="Next" class="h-[60px]">
                    </button>
                </div>
            </div>
        </div>
    </div>

    <x-sidebar></x-sidebar>
    <x-home-button></x-home-button>
</body>

</html>
