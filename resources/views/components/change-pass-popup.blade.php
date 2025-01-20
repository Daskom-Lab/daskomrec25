<details class="open mt-10">
    <!-- Explore Button -->
    <summary class="mt-5 text-primary relative transition-all duration-300 ease-in-out transform hover:scale-105 hover:brightness-150 active:scale-95 list-none">
        <img src="assets/Button Pink.webp" alt="Change" class="w-[180px]">
        <p class="absolute inset-0 flex items-center justify-center text-lg lg:text-xl font-bold">Change</p>
    </summary>

    <!-- Full-Screen Overlay -->
    <div class="fixed inset-0 flex items-center justify-center text-primary font-crimson-text bg-BlackLayer">
        <img src="assets/Stone Modal.webp" alt="Pop Up" class="absolute w-[600px] min-w-[300px] mx-10 sm:mx-3">
        <div class="absolute w-[300px] sm:w-[500px] mx-10 sm:mx-36 ">
            <span onclick="document.querySelector('details').removeAttribute('open')"
                class="absolute lg:-right-6 -right-6  -top-2 xs:-top-4 lg:-top-8 md:-top-8 sm:-top-8 w-20 h-20 text-white hover:duration-200  ">
                <img src="assets/Close Button.webp" alt="Close" class="w-[30px] xs:w-[40px] lg:w-[70px] md:w-[60px] transition-all duration-300 ease-in-out transform hover:scale-105 hover:brightness-110 active:scale-95 list-none">
            </span>

            <div class="text-center mx-auto">
                <h1 class="lg:text-md md:text-md sm:text-md text-xs font-bold">Discover your light within</h1>
                <p class="lg:text-4xl md:text-3xl text-lg mt-1 md:mt-3 lg:mt-3 font-im-fell-english">Are you sure you want to change password?</p>
            </div>  
            <div class="mt-4 sm:mt-8 lg:mt-10 md:mt-10 space-x-2">
                <button class="relative text-primary transition-all duration-300 ease-in-out transform hover:scale-105 hover:brightness-125 active:scale-95 list-none ">
                    <img src="assets/Button Pink.webp" alt="Yes" class="w-[80px] xs:w-[100px] lg:w-[180px] md:w-[180px] sm:w-[150px]">
                    <p class="absolute inset-0 flex items-center justify-center text-md lg:text-xl md:text-xl font-bold">Yes</p>
                </button>
                <button class="relative text-primary transition-all duration-300 ease-in-out transform hover:scale-105 hover:brightness-125 active:scale-95 list-none ">
                    <img src="assets/Button Pink.webp" alt="No" class="w-[80px] xs:w-[100px] lg:w-[180px] md:w-[180px] sm:w-[150px]">
                    <p class="absolute inset-0 flex items-center justify-center text-md lg:text-xl md:text-xl font-bold">No</p>
                </button>
            </div>
        </div>
    </div>
</details>