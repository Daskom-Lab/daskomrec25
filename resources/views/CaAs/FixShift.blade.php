<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shift</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-Shift bg-cover bg-center bg-no-repeat max-w-full scroll-x-hide overflow-hidden ">

    <img src="assets/Wall2.png" alt="Wall" class="fixed left-0 h-full w-auto">
    <img src="assets/Wall-Mobile.png" alt="Wall" class="fixed inset-0 w-[200px] sm:hidden">
    <img src="assets/Crystal 3.png" alt="Crystal" class="fixed bottom-0 left-0 h-96 w-auto scale-x-[-1] scale-y-[-1]">
    <img src="assets/Crystal 5.png" alt="Crystal" class="fixed bottom-0 z-10 left-36 h-52 w-auto">
    <img src="assets/Crystal 2.png" alt="Crystal" class="fixed top-0 z-10 left-0 h-full w-auto">
    <img src="assets/Shine.png" alt="Shine" class="fixed bottom-24 z-10 left-5 h-auto w-[70px] sm:w-auto">
    <img src="assets/Shine.png" alt="Shine" class="fixed bottom-10 z-10 left-32  h-auto w-[70px] sm:w-auto">
    <img src="assets/Wall 3.png" alt="Wall" class="fixed right-0 h-full w-auto opacity-0 lg:opacity-100 md:opacity-100">
    <img src="assets/Crystal 5.png" alt="Crystal" class="fixed bottom-0 -right-14 h-60 w-auto opacity-0 lg:opacity-100 md:opacity-100">
    <img src="assets/Shine.png" alt="Shine" class="fixed bottom-10 right-5 w-[200px] opacity-0 lg:opacity-100 md:opacity-100">
    
    <div class="absolute bg-BlackLayer w-full h-full z-20">
        <div class="container mx-auto py-5 font-crimson-text">
            <div class="inset-0 text-white text-center">
                <h2 class="font-crimson-text text-md lg:text-lg md:text-lg pb-1 font-bold">Discover the light within</h2>
                <h1 class="text-xl md:text-2xl lg:text-2xl">Choose Your Shift</h1>
            </div>
            <div class="flex relative justify-center -top-10">
                <img src="assets/Announcement Stone.png" alt="" class="h-[700px]">
                <div class="absolute text-justify mt-32 w-[230px] lg:w-[250px]">
                    <p class="lg:text-lg text-base font-bold mb-5">Once you choose this shift, you couldn't replace it, your shift will be show below:</p>
                    <p class="ml-3 lg:text-md text-sm font-im-fell-english">Date: Monday, 18th December 2024</p>
                    <p class="ml-3 lg:text-md text-sm font-im-fell-english">Time: 10.00-12.00 WIB</p>
                    <p class="lg:text-lg text-base font-bold mt-5">Please always re-check your shift also our OA Line for next information. Thank you.</p>
                </div>
                <div class="absolute bottom-[70px] ml-56">
                    <img src="assets/Sign DLOR.png" alt="Sign" class="w-[120px]">
                </div>
            </div>
        </div>
        </div>
    <x-sidebar></x-sidebar>
    <x-home-button></x-home-button>
    

</body>
</html>