<!-- resources/views/components/change-pass-form.blade.php -->

@props([])
<form 
  id="changePassForm"
  method="POST"
  action="{{ route('caas.change-password.update') }}"
  class="w-full max-w-lg px-4 sm:px-8 md:px-12 space-y-6 flex flex-col items-center justify-center mx-auto"
>
    @csrf
    
    <!-- Old Password -->
    <div class="w-full">
        <label for="old_password" class="block text-base text-start sm:text-lg text-white font-serif mb-2">
            Old Password
        </label>
        <input
            type="password"
            name="old_password"
            id="old_password"
            class="w-full p-3 bg-PlaceHolder bg-center rounded-lg shadow-md text-black text-base sm:text-lg"
            placeholder="Enter your old password"
            required
        />
    </div>

    <!-- New Password -->
    <div class="w-full">
        <label for="new_password" class="block text-base text-start sm:text-lg text-white font-serif mb-2">
            New Password
        </label>
        <input
            type="password"
            name="new_password"
            id="new_password"
            class="w-full p-3 bg-PlaceHolder bg-center rounded-lg shadow-md text-black text-base sm:text-lg"
            placeholder="Enter your new password"
            required
        />
    </div>
    <x-change-pass-popup />
</form>
