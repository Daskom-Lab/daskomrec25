<!-- resources/views/components/login-form-caas.blade.php -->

<form 
  action="{{ route('caas.login.authenticate') }}" 
  method="POST" 
  class="w-full max-w-lg px-4 sm:px-8 md:px-12 space-y-6 flex flex-col items-center justify-center mx-auto"
>
  @csrf <!-- Include CSRF protection -->

  <!-- Username Input -->
  <div class="w-full">
    <label for="nim" class="block text-base sm:text-lg text-white font-serif mb-2">
      Username
    </label>
    <input
      type="text"
      id="nim"
      name="nim"
      class="w-full p-3 bg-PlaceHolder bg-center rounded-lg shadow-md text-black text-base sm:text-lg"
      placeholder="Enter your username"
      required
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
      name="password"
      class="w-full p-3 bg-PlaceHolder bg-center rounded-lg shadow-md text-black text-base sm:text-lg"
      placeholder="Enter your password"
      required
    />
  </div>

  <!-- Submit Button -->
  <button  
    type="submit"
    class="w-full max-w-[11rem] bg-Button bg-center bg-no-repeat py-3 rounded-lg text-primary text-base sm:text-xl font-bold font-crimson-text relative transition-all duration-300 ease-in-out transform hover:scale-105 active:scale-95"
  >
    <span
      class="absolute inset-0 bg-Button bg-center bg-no-repeat rounded-lg filter blur-md opacity-50 pointer-events-none"
    ></span>
    <span class="relative">Explore</span>
  </button>
</form>
