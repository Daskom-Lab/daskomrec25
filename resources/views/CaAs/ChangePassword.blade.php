<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
</head>
<body class="font-im-fell-english min-h-screen bg-ChangePassword bg-cover bg-center bg-no-repeat max-w-full overflow-x-hidden ">
    
    <!-- Background Image -->
    <canvas id="webgl-canvas" class="absolute w-screen h-screen top-0 -z-10"></canvas>

    <img src="assets/Wall2.webp" 
        alt="left wall" 
        class="fixed left-0 h-full w-auto ">    
    <img src="assets/Wall-Mobile.webp" 
        alt="left wall" 
        class="fixed inset-0 h-full w-full sm:hidden  ">
    <img src="assets/Crystal 3.webp" 
        alt="bottom left crystal 1" 
        class="fixed bottom-0 left-0 h-96 w-auto scale-x-[-1] scale-y-[-1]">
    <img src="assets/Crystal 5.webp" 
        alt="bottom left crystal 2" 
        class="fixed bottom-0 z-10 left-36 h-52 w-auto">
    <img src="assets/Crystal 2.webp" 
         alt="bottom left crystal" 
         class="fixed top-0 z-10 left-0 h-full w-auto">
    <img src="assets/Shine.webp" 
        alt="shine" 
        class="fixed bottom-24 z-10 left-5 h-auto w-[70px] sm:w-auto pulsing">
   
   <img src="assets/Shine.webp" 
        alt="shine" 
        class="fixed bottom-10 z-10 left-32  h-auto w-[70px] sm:w-auto pulsing">

    <div class="absolute z-20 h-full w-full bg-black bg-opacity-50 flex flex-col items-center justify-center text-center">
        <header class="mb-10 px-4">
            <h1 class="text-3xl sm:text-3xl md:text-5xl text-white font-serif mb-4 text-shadow-md">
                Modify Your Password
            </h1>
            <p class="text-base sm:text-sm md:text-xl text-white font-serif max-w-2xl mx-auto leading-relaxed text-shadow-sm">
                Please enter the Old Password & New Password for minimum 8 characters
            </p>
        </header>

<!-- Notifikasi Sukses & Error (jika ada) -->
<div class="w-full max-w-lg px-4 mb-4">
    @if(session('success'))
        <div class="bg-green-100 text-green-700 rounded-md p-3 mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-100 text-red-700 rounded-md p-3 mb-4 text-sm">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

        <x-change-pass-form></x-change-pass-form>
    </div>
    <x-sidebar></x-sidebar>
    <x-home-button></x-home-button>
    

</body>
</html>
