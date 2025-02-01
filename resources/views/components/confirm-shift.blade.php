{{-- resources/views/components/confirm-shift.blade.php --}}
{{-- Pop-up konfirmasi "Are you sure to pick this shift?" --}}

<div
    class="fixed hidden inset-0 flex items-center justify-center text-primary font-crimson-text bg-BlackLayer"
    id="popupShift"
>
    {{-- Background pop-up --}}
    <img src="{{ asset('assets/Stone Modal.webp') }}" alt="Pop Up" class="absolute w-[600px] min-w-[300px] mx-10 sm:mx-3">

    <div class="absolute w-[300px] sm:w-[500px] mx-10 sm:mx-36 text-center">
        {{-- Tombol Close --}}
        <span
            onclick="hideShift()"
            class="absolute lg:-right-6 -right-6 -top-2 xs:-top-4 lg:-top-8 md:-top-8 sm:-top-8 w-20 h-20 text-white hover:duration-200 cursor-pointer"
        >
            <img
                src="{{ asset('assets/Close Button.webp') }}"
                alt="Close"
                class="w-[30px] xs:w-[40px] lg:w-[70px] md:w-[60px] transition-all duration-300 ease-in-out transform hover:scale-105 active:scale-95 hover:brightness-110"
            >
        </span>

        <div class="text-center mx-auto">
            <h1 class="lg:text-md md:text-md sm:text-md text-xs font-bold">Discover your light within</h1>
            <p class="lg:text-4xl md:text-3xl text-lg mt-1 md:mt-3 lg:mt-3 font-im-fell-english">Are you sure you want to <br> add this Shift?</p>
        </div>  

        {{-- Tombol Yes / No --}}
        <div class="mt-4 sm:mt-8 lg:mt-10 space-x-2 inline-block">
            {{-- Form POST ke route('caas.shift.pick') --}}
            <form
                method="POST"
                action="{{ route('caas.shift.pick') }}"
                class="inline-block"
                onsubmit="return confirm('Pick this shift now?');"
            >
                @csrf
                {{-- Hidden input shift_id yang kita isi lewat JS --}}
                <input type="hidden" name="shift_id" id="shift_id_input" value="">

                {{-- Tombol YES --}}
                <button
                    type="submit"
                    class="relative text-primary transition-all duration-300 ease-in-out transform hover:scale-105 hover:brightness-125 active:scale-95"
                >
                    <img
                        src="{{ asset('assets/Button Pink.webp') }}"
                        alt="Yes"
                        class="w-[80px] xs:w-[100px] lg:w-[180px] md:w-[180px] sm:w-[150px]"
                    >
                    <p class="absolute inset-0 flex items-center justify-center text-md lg:text-xl md:text-xl font-bold">
                        Yes
                    </p>
                </button>
            </form>

            {{-- Tombol NO (tutup popup) --}}
            <button
                type="button"
                class="relative text-primary transition-all duration-300 ease-in-out transform hover:scale-105 hover:brightness-125 active:scale-95"
                onclick="hideShift()"
            >
                <img
                    src="{{ asset('assets/Button Pink.webp') }}"
                    alt="No"
                    class="w-[80px] xs:w-[100px] lg:w-[180px] md:w-[180px] sm:w-[150px]"
                >
                <p class="absolute inset-0 flex items-center justify-center text-md lg:text-xl md:text-xl font-bold">
                    No
                </p>
            </button>
        </div>
    </div>
</div>
