<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body 
    class="font-im-fell-english flex flex-col items-center justify-center min-h-screen px-4 sm:px-8 relative overflow-hidden cursor-Wand"
>
    <!-- Background Image -->
    <div 
        class="absolute inset-0 bg-LoginCaAs bg-cover bg-center bg-no-repeat -z-10"
        >
    </div>
     <!-- Upper Image -->
     <div class="absolute bottom-0 -z-10">
        <img src="assets/Lower Shine.png" alt="upper wall" class="w-full h-auto">
    </div>
    <div class="absolute top-0 -z-10">
        <img src="assets/Upper Shine.png" alt="upper wall" class="w-full h-auto ">
    </div>
    <!-- Upper Image -->
    <div class="absolute bottom-0 -z-10">
        <img src="assets/Upper.png" alt="upper wall" class="w-full h-auto">
    </div>
    <div class="absolute top-0 -z-10">
        <img src="assets/Upper.png" alt="upper wall" class="w-full h-auto scale-y-[-1]">
    </div>
   
    <!-- Greeting Section -->
    <header class="text-center mb-10 px-4">
        <h1 class="text-3xl sm:text-3xl md:text-5xl text-white font-serif mb-4 text-shadow-md">
            Greeting, Wanderer!
        </h1>
        <p class="text-base sm:text-sm md:text-xl text-white font-serif max-w-2xl mx-auto leading-relaxed text-shadow-sm">
            Your journey begins here. Please enter your login details and password below to continue your adventure.
        </p>
    </header>
    <!-- Login Form Component -->
    <x-login-form-caas></x-login-form-caas>
    <!-- Footer Text -->
    <div class="mt-10 text-center px-4">
        <p class="text-sm sm:text-base md:text-lg text-white font-serif text-shadow-sm">
        Discover your light within
        </p>
    </div>
</body>
</html>