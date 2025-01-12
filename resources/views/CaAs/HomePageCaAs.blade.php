<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DLOR 2025</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-im-fell-english min-h-screen bg-HomePageCaAs bg-cover bg-center bg-no-repeat max-w-full overflow-x-hidden cursor-Wand">
    
    <!-- Background Image -->
    <div class="fixed inset-0 grid place-items-center -z-50">
        <img src="assets/Light.png"
             alt="upper shine light" 
             class="h-full w-auto opacity-80 ">
    </div>
    
    <img src="assets/Wall2.png" 
    alt="left wall" 
    class="fixed -z-30 -left-24 h-[55%] sm:h-[90%] w-auto">

    <div class="fixed inset-0 grid place-items-center -z-20">
          <img src="assets/Dust.png" 
          alt="bats" 
          class="h-auto w-full sm:hidden -">
    </div>
    
    

    <img src="assets/Wall2.png" 
    alt="right wall" 
    class="fixed -z-10 -right-32 h-full w-full sm:w-auto scale-x-[-1] scale-y-[-1]">
    
    <img src="assets/Crystal 1.png" 
         alt="bottom left crystal" 
         class="fixed bottom-0 z-10 left-0 h-52 sm:h-96 w-auto">
    
    <img src="assets/Crystal 3.png" 
         alt="top right crystal" 
         class="fixed top-0 z-10 right-0 h-96 w-auto">
    
    <img src="assets/Bats.png" 
         alt="bats" 
         class="fixed top-0 z-10 left-0 h-52 sm:h-96 w-auto">
    
    <img src="assets/Shine.png" 
         alt="shine" 
         class="fixed bottom-20 z-10 left-0 h-auto w-[70px] sm:w-auto">
    
    <img src="assets/Shine.png" 
         alt="shine" 
         class="fixed bottom-0 z-10 left-24 sm:left-40 h-auto w-[70px] sm:w-auto">
    <img src="assets/Star 1.png" 
         alt="star" 
         class="fixed bottom-0 z-10 right-0  h-auto w-auto">
    <img src="assets/Star 2.png" 
         alt="star" 
         class="fixed bottom-0 z-10 right-0  h-auto w-auto">

     <div class="absolute inset-0 flex flex-col items-center justify-center z-10 text-center px-4">
          <h1 class="text-white font-normal text-3xl md:text-5xl sm:text-3xl">Welcome To The Crystal Cavern</h1>
          <p class="text-white py-2 text-lg font-bold leading-[32px] font-crimson-text md:text-xl md:leading-[24px] sm:text-sm sm:leading-[20px]">discover your light within</p>
      </div>

    <x-sidebar></x-sidebar>
    

</body>
</html>
