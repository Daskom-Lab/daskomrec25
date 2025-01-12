<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-im-fell-english min-h-screen bg-ChangePassword bg-cover bg-center bg-no-repeat max-w-full overflow-x-hidden cursor-Wand">
    
    <!-- Background Image -->
    <img src="assets/Wall2.png" 
        alt="left wall" 
        class="fixed left-0 h-full w-auto ">    
    <img src="assets/Wall-Mobile.png" 
        alt="left wall" 
        class="fixed inset-0 h-full w-full sm:hidden  ">
    <img src="assets/Crystal 3.png" 
        alt="bottom left crystal 1" 
        class="fixed bottom-0 left-0 h-96 w-auto scale-x-[-1] scale-y-[-1]">
    <img src="assets/Crystal 5.png" 
        alt="bottom left crystal 2" 
        class="fixed bottom-0 z-10 left-36 h-52 w-auto">
    <img src="assets/Crystal 2.png" 
         alt="bottom left crystal" 
         class="fixed top-0 z-10 left-0 h-full w-auto">
    <img src="assets/Shine.png" 
        alt="shine" 
        class="fixed bottom-24 z-10 left-5 h-auto w-[70px] sm:w-auto">
   
   <img src="assets/Shine.png" 
        alt="shine" 
        class="fixed bottom-10 z-10 left-32  h-auto w-[70px] sm:w-auto">

    <div class="absolute z-20 h-full w-full bg-black bg-opacity-50 flex flex-col items-center justify-center text-center">
        <header class="mb-10 px-4">
            <h1 class="text-3xl sm:text-3xl md:text-5xl text-white font-serif mb-4 text-shadow-md">
                Modify Your Password
            </h1>
            <p class="text-base sm:text-sm md:text-xl text-white font-serif max-w-2xl mx-auto leading-relaxed text-shadow-sm">
                Please enter the Old Password & New Password for minimum 8 characters
            </p>
        </header>
        <x-change-pass-form></x-change-pass-form>
    </div>
    <x-sidebar></x-sidebar>
    

</body>
</html>
