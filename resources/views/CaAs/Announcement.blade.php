<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcement</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-Announcement bg-cover bg-center bg-fixed bg-no-repeat min-h-screen max-w-full scroll-x-hide text-primary overflow-hidden flex items-center justify-center relative cursor-Wand">

    <img src="assets/Shadow Right.png" alt="Shadow" class="fixed right-0 top-0 w-1/2 h-full">
    <img src="assets/Bats.png" alt="Bats" class="fixed -top-72 left-0 w-[750px]">
    <img src="assets/Crystals.png" alt="Crystal" class="fixed w-[1400px] h-auto min-w-[1000px] ml-[150px] bottom-0">
    <img src="assets/Waterfall.png" alt="Waterfall" class="fixed min-w-[800px] h-full top-0 md:h-full">
    <img src="assets/Magic Tree.png" alt="Magic Tree" class="fixed w-[650px] h-auto min-w-max lg:-right-28 -right-52 bottom-5">
    <img src="assets/Lower.png" alt="Wall" class="fixed -bottom-5 w-full lg:h-full h-[500px]">

    <div class="container max-w-xl mx-auto py-5 font-crimson-text">
        <div class="flex relative justify-center">
            <img src="assets/Announcement Stone.png" alt="" class="h-[700px] min-h-max">
            <div class="absolute text-center mt-28 mx-[150px]">
                <h1 class="lg:text-3xl text-3xl font-bold">Announcement</h1>
                <hr class="mt-2 border-primary w-3/5 mx-auto mb-7 lg:mb-10">
                <h2 class="text-md lg:text-lg text-left font-bold mb-5">
                    Congratulations,
                    <br>
                    STEVANNIE PRATAMA
                </h2>
                <p class="text-xs lg:text-sm text-justify font-im-fell-english">
                    You've Successfully Completed Your Journey!
                    <br>
                    <br>
                    You've ventured far, overcome obstacles, and now, the treasures of your hard work await you. With dedication and courage, you've unlocked the <b>INTERVIEW</b>.
                    <br>
                    <br>
                    Thank you for being part of the Crystal Cavern adventure. This is just the beginning. Your next chapter begins now.
                    <br>
                    Celebrate your achievement and continue forging your path!
                </p>
            </div>
            <div class="absolute bottom-28 mr-16">
                <button class="relative text-primary transition-all duration-300 ease-in-out transform hover:scale-105 active:scale-95 list-none">
                    <img src="assets/Button Pink.png" alt="No" class="w-[150px]">
                    <p class="absolute inset-0 flex items-center justify-center text-lg font-bold">Shift</p>
                </button>
            </div>
            <div class="absolute bottom-[70px] ml-56">
                <img src="assets/Sign DLOR.png" alt="" class="w-[120px]">
            </div>
        </div>
    </div>
    <x-sidebar></x-sidebar>
    
</body>
</html>