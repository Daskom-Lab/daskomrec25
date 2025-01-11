<details class="open mt-10">
    <!-- Explore Button -->
    <summary class="mt-5 text-primary relative transition-all duration-300 ease-in-out transform hover:scale-105 active:scale-95 list-none">
        <img src="assets/Button Pink.png" alt="Change" class="w-[180px]">
        <p class="absolute inset-0 flex items-center justify-center text-lg lg:text-xl font-bold">Change</p>
    </summary>

    <!-- Full-Screen Overlay -->
    <div class="fixed inset-0 flex items-center justify-center text-primary font-crimson-text bg-BlackLayer">
        <img src="assets/Stone Model.png" alt="Pop Up" class="w-[750px] min-w-[400px]">
        <div class="absolute lg:mx-[500px] md:mx-[200px] mx-12">
            <span onclick="document.querySelector('details').removeAttribute('open')"
                class="absolute -right-7 lg:-right-6 md:right-3 -top-4 lg:-top-16 md:-top-16 w-20 h-20 text-white hover:duration-200 cursor-pointer">
                <img src="assets/Close Button.png" alt="Close" class="w-[50px] lg:w-[90px] md:w-[90px] transition-all duration-300 ease-in-out transform hover:scale-105 active:scale-95 list-none">
            </span>

            <div class="text-center mx-auto">
                <h1 class="lg:text-md md:text-md text-base font-bold">Discover your light within</h1>
                <p class="lg:text-4xl md:text-3xl text-[27px] mt-1 md:mt-3 lg:mt-3 font-im-fell-english">Are you sure you want to change password?</p>
            </div>  
            <div class="mt-4 lg:mt-10 md:mt-14 space-x-2">
                <button class="relative text-primary transition-all duration-300 ease-in-out transform hover:scale-105 active:scale-95 list-none">
                    <img src="assets/Button Pink.png" alt="Yes" class="w-[100px] lg:w-[180px] md:w-[180px]">
                    <p class="absolute inset-0 flex items-center justify-center text-md lg:text-xl md:text-xl font-bold">Yes</p>
                </button>
                <button class="relative text-primary transition-all duration-300 ease-in-out transform hover:scale-105 active:scale-95 list-none">
                    <img src="assets/Button Pink.png" alt="No" class="w-[100px] lg:w-[180px] md:w-[180px]">
                    <p class="absolute inset-0 flex items-center justify-center text-md lg:text-xl md:text-xl font-bold">No</p>
                </button>
            </div>
        </div>
    </div>
</details>