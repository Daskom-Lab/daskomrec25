<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Gem</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-Gems bg-cover bg-fixed bg-no-repeat min-h-screen max-w-full scroll-x-hide text-white overflow-hidden over">
    
    <!-- Background Image -->
    <img src="assets/Wall2.png" alt="Wall" class="fixed left-0 h-full w-auto">
    <img src="assets/Wall-Mobile.png" alt="Wall" class="fixed inset-0 w-[200px] sm:hidden">
    <img src="assets/Crystal 3.png" alt="Crystal" class="fixed w-[530px] top-2 -left-[340px]">
    <img src="assets/Shine.png" alt="Shine" class="fixed w-[150px] top-0 left-0 -rotate-[7deg]">
    <img src="assets/Shine.png" alt="Shine" class="fixed w-[150px] top-20 left-20 -rotate-[10deg]">
    <img src="assets/Crystal 1.png" alt="Crystal" class="fixed w-[220px] bottom-0 -left-1">
    <img src="assets/Flower 1.png" alt="Flower" class="fixed bottom-0 left-0 w-[150px]">
    <img src="assets/Crystal 5.png" alt="Crystal" class="fixed w-[170px] bottom-0 left-[250px]">
    <img src="assets/Flower 2.png" alt="Flower" class="fixed bottom-0 left-[250px] w-[140px]">
    <img src="assets/Sparkle.png" alt="Dust" class="absolute min-w-max right-0 -top-5 transform scale-x-[-1]">

    <div class="absolute flex items-center justify-center bg-BlackLayer w-full h-full z-20">
    <div class="container h-full max-w-full sm:max-w-[80%] md:max-w-[90%] lg:max-w-[70%] mx-auto font-im-fell-english">
        <div class="mt-16 relative justify-center">
            <div class="text-center">
                <h1 class="text-lg font-crimson-text pb-2">Discover the light within</h1>
                <h1 class="text-3xl">Pick Your Gem</h1>
            </div>
            <div class="owl-carousel owl-theme justify-evenly mx-auto my-4">
                <div class="relative h-[410px] w-[200px] xs:w-[400px] flex justify-center items-center mx-auto">
                    <img src="assets/Gems Card/Gems (1).png" alt="Gem Card" class="max-w-[250px] rounded">
                </div>  
                <div class="relative h-[410px] w-[200px] xs:w-[400px] flex justify-center items-center mx-auto">
                    <img src="assets/Gems Card/Gems (6).png" alt="Gem Card" class="max-w-[250px] rounded">
                </div>  
                <div class="relative h-[410px] w-[200px] xs:w-[400px] flex justify-center items-center mx-auto">
                    <img src="assets/Gems Card/Gems (7).png" alt="Gem Card" class="max-w-[250px] rounded">
                </div>  
                <div class="relative h-[410px] w-[200px] xs:w-[400px] flex justify-center items-center mx-auto">
                    <img src="assets/Gems Card/Gems (8).png" alt="Gem Card" class="max-w-[250px] rounded">
                </div>  
                <div class="relative h-[410px] w-[200px] xs:w-[400px] flex justify-center items-center mx-auto">
                    <img src="assets/Gems Card/Gems (9).png" alt="Gem Card" class="max-w-[250px] rounded">
                </div>    
            </div>
            <div class="flex justify-center h-[60px] space-x-2">
                <button class="owl-prev hover:scale-105 hover:brightness-110 active:scale-95" type="button">
                    <img src="assets/Prev.png" alt="Prev" class="h-full">
                </button>
                <button class="text-primary transition-all duration-300 ease-in-out transform hover:scale-105 hover:brightness-150 active:scale-95" onclick="showGem()">
                    <img src="assets/Button Pink.png" alt="Save" class="h-[75%] ">
                    <p class="absolute inset-0 flex items-center justify-center text-xl font-bold">Save</p>
                </button>
                <button class="owl-next hover:scale-105 hover:brightness-110 active:scale-95" type="button">
                   <img src="assets/Next.png" alt="Next" class="h-full ">
                </button>
            </div>
            <x-confirm-gem></x-confirm-gem>
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{ asset('js/slider.js') }}"></script>

    <x-sidebar></x-sidebar>
    <x-home-button></x-home-button>
    
</body>
</html>