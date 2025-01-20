<div class="w-full max-w-lg px-4 sm:px-8 md:px-12 space-y-6 flex flex-col items-center justify-center mx-auto">
  <!-- Username Input -->
  <div class="w-full">
    <label for="username" class="block text-base sm:text-lg text-white font-serif mb-2">
      Username
    </label>
    <input
      type="text"
      id="username"
      class="w-full p-3 bg-PlaceHolder bg-center rounded-lg shadow-md text-black text-base sm:text-lg"
      placeholder="Enter your username"
    />
  </div>

  <!-- Password Input -->
  <div class="w-full">
    <label for="password" class="block text-base sm:text-lg text-white font-serif mb-2">
      Password
    </label>
    <input
      type="password"
      id="password"
      class="w-full p-3 bg-PlaceHolder bg-center rounded-lg shadow-md text-black text-base sm:text-lg"
      placeholder="Enter your password"
    />
  </div>

  <!-- Explore Button -->
  <button  
    class="w-full max-w-[11rem] bg-Button bg-center bg-no-repeat py-3 rounded-lg text-primary text-base sm:text-xl font-bold font-crimson-text relative transition-all duration-300 ease-in-out transform hover:scale-105 hover:brightness-125 active:scale-95 "
  >
    <a href="/CaAs" class="">
      <span
        class="absolute inset-0 bg-Button bg-center bg-no-repeat rounded-lg filter blur-md opacity-50 "
      ></span>
      <span class="relative ">Explore</span>
    </a>
  </button>
</div>