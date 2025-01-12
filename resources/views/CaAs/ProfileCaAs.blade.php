<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-Profile bg-cover bg-center bg-no-repeat max-w-full overflow-x-hidden cursor-Wand">
    
    <!-- Background Image -->
    <img src="assets/Wall2.png" alt="Wall" class="fixed left-0 h-full w-auto">
    <img src="assets/Wall-Mobile.png" alt="Wall" class="fixed inset-0 h-full w-full sm:hidden">
    <img src="assets/Crystal 3.png" alt="Crystal" class="fixed bottom-0 left-0 h-96 w-auto scale-x-[-1] scale-y-[-1]">
    <img src="assets/Crystal 5.png" alt="Crystal" class="fixed bottom-0 z-10 left-36 h-52 w-auto">
    <img src="assets/Crystal 2.png" alt="Crystal" class="fixed top-0 z-10 left-0 h-full w-auto">
    <img src="assets/Shine.png" alt="Shine" class="fixed bottom-24 z-10 left-5 h-auto w-[70px] sm:w-auto">
    <img src="assets/Shine.png" alt="Shine" class="fixed bottom-10 z-10 left-32  h-auto w-[70px] sm:w-auto">
    <img src="assets/Wall 3.png" alt="Wall" class="fixed right-0 h-full w-auto opacity-0 lg:opacity-100 md:opacity-100">
    <img src="assets/Crystal 5.png" alt="Crystal" class="fixed bottom-0 -right-14 h-60 w-auto opacity-0 lg:opacity-100 md:opacity-100">
    <img src="assets/Shine.png" alt="Shine" class="fixed bottom-10 right-5 w-[200px] opacity-0 lg:opacity-100 md:opacity-100">

    <div class="absolute flex items-center justify-center bg-BlackLayer w-full h-full z-20">
        <div class="absolute inset-0 text-white text-center mt-24">
            <h2 class="font-crimson-text text-xl pb-2">Discover your light within</h2>
            <h1 class="font-im-fell-english text-5xl">Profile</h1>
        </div>
        <div class="relative group mt-14">
            <div class="transition-transform duration-300 group-hover:scale-105">
                <img src="assets/Profile Card.png" alt="Profile Card" class="w-[450px] relative z-10">
                <div class="absolute inset-0 bg-white blur-xl opacity-0 transition-opacity duration-300 group-hover:opacity-10"></div>
                <div class="absolute inset-0 flex items-center text-justify z-20 mx-[89px] xs:mx-[100px] sm:mx-[105px] md:mx-[105px] lg:mx-[105px] mt-[173px] sm:mt-[205px] lg:mt-[203px] md:mt-[203px] xs:mt-[196px]">
                    <div class="text-[9px] sm:text-[10px] md:text-[11px] lg:text-[11px] text-profile font-rye">
                        <p>NAMA: STEVANNIE PRATAMA</p>
                        <p>NIM: 101012340343</p>
                        <p>JURUSAN: TEKNIK TELEKOMUNIKASI</p>
                        <p>KELAS: TT-47-INT</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <x-sidebar></x-sidebar>
    

</body>
</html>
