<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gem</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-Gems bg-cover bg-fixed bg-no-repeat min-h-screen max-w-full scroll-x-hide text-white overflow-hidden ">
    
    <!-- Background Image -->
    <img src="assets/Wall2.webp" alt="Wall" class="fixed left-0 h-full w-auto">
    <img src="assets/Wall-Mobile.webp" alt="Wall" class="fixed inset-0 w-[200px] sm:hidden">
    <img src="assets/Crystal 3.webp" alt="Crystal" class="fixed w-[530px] top-2 -left-[340px]">
    <img src="assets/Shine.webp" alt="Shine" class="fixed w-[150px] top-0 left-0 -rotate-[7deg]">
    <img src="assets/Shine.webp" alt="Shine" class="fixed w-[150px] top-20 left-20 -rotate-[10deg]">
    <img src="assets/Crystal 1.webp" alt="Crystal" class="fixed w-[220px] bottom-0 -left-1">
    <img src="assets/Flower 1.webp" alt="Flower" class="fixed bottom-0 left-0 w-[150px]">
    <img src="assets/Crystal 5.webp" alt="Crystal" class="fixed w-[170px] bottom-0 left-[250px]">
    <img src="assets/Flower 2.webp" alt="Flower" class="fixed bottom-0 left-[250px] w-[140px]">
    <img src="assets/Sparkle.webp" alt="Dust" class="absolute min-w-max right-0 -top-5 transform scale-x-[-1]">

    <div class="absolute flex items-center justify-center bg-BlackLayer w-full h-full z-20">
        <div class="absolute inset-0 text-white text-center mt-24">
            <h1 class="text-lg font-crimson-text pb-2">Discover the light within</h1>
            <h1 class="text-3xl font-im-fell-english">Your Active Gem</h1>
        </div>
        <div class="relative group mt-16 mx-14">
            <div class="transition-transform duration-300 group-hover:scale-105">
                <img src="assets/Gems Card/Gems (8).webp" alt="Gem Card" class="relative z-10 w-[310px] rounded">
                <div class="absolute inset-0 bg-white blur-xl opacity-0 transition-opacity duration-300 group-hover:opacity-30"></div>  
            </div>
        </div>
    </div>

    <x-sidebar></x-sidebar>
    <x-home-button></x-home-button>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{ asset('js/slider.js') }}"></script>
</body>
</html>