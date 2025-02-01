<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DLOR 2025</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="font-im-fell-english flex flex-col ">

    <section class="relative h-screen bg-LandingCaas1 bg-cover bg-center overflow-x-hidden overflow-y-clip">
        <img src="assets/RightUpperRock.webp" id="Rock1" alt="Right Upper Rock" class="absolute right-0 top-0 w-[40vw] sm:w-[25vw] h-auto">
        <img src="assets/LeftUpperRock.webp" id="Rock2" alt="Left Upper Rock" class="absolute -left-12 sm:left-0 top-0 w-[50vw] sm:w-[25vw] h-auto">
        
        
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4" >
            <img src="assets/Logo.webp" alt="Logo" class="absolute top-20 w-auto h-8 sm:h-10 md:h-12">
            <p class="text-white py-2 text-base sm:text-lg md:text-xl lg:text-2xl font-normal leading-6 sm:leading-7 md:leading-8 lg:leading-10 font-crimson-text max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg" id="massage">
                <span class="fade-up" style="animation-delay: 0.7s;">From the depths of the earth to the highest peaks, <span class="font-bold">we pursue a shared destiny.</span></span>
                <br>
                <br class="hidden sm:block">
                <span class="fade-up" style="animation-delay: 2s;">Heed the call, Adventurer, for no journey is too long <span class="font-bold">and no preparation is ever too much.</span></span>
                <br>
                <br>
                <span class="fade-up" style="animation-delay: 3.3s;">Push forward, for no matter how treacherous the journey, <span class="font-bold">the treasure at the end is worth the risk.</span></span>
                <br>
                <br class="hidden sm:block">
                <span class="fade-up" style="animation-delay: 4.6s;">With each step you take, your light will grow brighter, <span class="font-bold">guiding you toward your ultimate destiny.</span></span>
            </p>
        </div>
        <img src="assets/Land.svg" alt="Land" class="absolute bottom-0 w-full h-[60vh] sm:h-[100vh]">


        <img src="assets/LeftBottomElement.webp" alt="Bottom Left Element" class="absolute left-0 bottom-0 w-[40vw] sm:w-[35vw] md:w-[22vw] h-auto" id="BL-Element">
        <img src="assets/RightBottomElement.webp" alt="Bottom Right Element" class="absolute right-0 bottom-0 w-[40vw] sm:w-[35vw] md:w-[23vw] h-auto" id="BR-Element">
        
    </section>
    <section class="relative h-screen bg-LandingCaas2 bg-cover bg-center overflow-x-hidden overflow-y-hidden">
        <img src="assets/Land.svg" alt="Land" class="absolute top-0 w-full h-[100vh] scale-y-[-1]">
        <img src="assets/LandingShine.webp" alt="Shine" class="absolute w-full h-[50vh]  -bottom-5">
        <img src="assets/RightBottomElement[2].webp" alt="Shine" class="absolute w-[40vw] sm:w-[35vw] md:w-[22vw] h-auto right-0 bottom-0">
        <img src="assets/leftBottomElement[2].webp" alt="Shine" class="absolute w-[40vw] sm:w-[35vw] md:w-[22vw] h-auto left-0 bottom-0">
        <div class="absolute w-full h-full flex justify-center items-center overflow-y-hidden ">
            <div class="absolute bottom-[10%] flex justify-center items-center w-fit h-fit">

                <img src="assets/Portal.webp" alt="Portal" class="bottom-0 size-[28rem] h-auto z-10">
                <a href="/login" class="absolute w-[120px] h-auto bottom-[38%] z-10">
                    <button class="absolute w-full h-auto py-4 rounded-lg text-primary text-base sm:text-xl font-bold font-crimson-text overflow-hidden transition-all duration-300 ease-in-out transform hover:scale-105 hover:brightness-150 active:scale-95 ">   
                        <img src="assets/Button Pink.webp" alt="button" class="w-full h-full absolute inset-0 -z-10">
                        <span class="absolute inset-0 flex justify-center items-center text-center">
                            Start
                        </span>
                    </button>
                </a>
            </div>
            <div class="h-screen right-10 bottom-5 w-[50vw] sm:w-[30vw]">

            </div>
            <img src="assets/Bubbles.webp" alt="Bubble" class="absolute right-10 bottom-5 w-[50vw] sm:w-[30vw] h-auto z-20 -rotate-90">
            <img src="assets/Bubbles.webp" alt="Bubble" class="absolute bottom-0 left-5 w-[80vw] sm:w-[30vw] h-auto z-0 -rotate-90">

        </div>

    </section>

    <script>
        
        let rock1 = document.getElementById('Rock1');
        let rock2 = document.getElementById('Rock2');
        let massage = document.getElementById('massage');
        let BR = document.getElementById('BR-Element');
        let BL = document.getElementById('BL-Element');
        //Parallax Handler
        window.addEventListener('scroll', () =>{
            let value = window.scrollY;

            rock1.style.marginTop = value * -1.3 + 'px';
            rock2.style.marginTop = value * -1.3 + 'px';
            massage.style.marginTop = value * 1.5 + 'px';
            BR.style.right = value * -1.2 + 'px';
            BL.style.left = value * -1.2 + 'px';
        });


        let scrollInterval = null; 
        let isScrolling = false;  

        // Start or pause scrolling on single click
        document.onclick = () => {
            if (isScrolling) {
                clearInterval(scrollInterval);
                isScrolling = false;
            } else {
                scrollInterval = setInterval(() => {
                    window.scrollBy(0, 1); 
                }, 1); 
                isScrolling = true;
            }
        };

        // Reset scrolling on double-click
        document.ondblclick = () => {
            clearInterval(scrollInterval); // Stop scrolling
            window.scrollTo(0, 0);         // Reset to the top of the page
            isScrolling = false;
        };
    </script>

</body>