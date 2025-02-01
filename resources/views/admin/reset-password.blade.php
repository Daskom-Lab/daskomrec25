@extends('admin.layouts.app2')

@section('title', 'Reset Password Admin')

@section('content')
<div 
  class="flex flex-col items-center justify-center min-h-screen px-4 font-im-fell-english"
>
    <!-- Reset Password Card -->
    <div 
      class="relative bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-lg 
             rounded-[30px] p-8 -mt-8 shadow-xl w-full max-w-xl mx-auto border border-white/20"
    >
        <!-- Heading -->
        <h1 
          class="text-center text-putih font-im-fell-english mb-4
                 text-3xl sm:text-4xl md:text-5xl"
        >
            Modify Your Password
        </h1>
        <p 
          class="text-center text-putih mb-3
                 text-base sm:text-lg md:text-xl"
        >
            Please enter your old password & new password (min 8 chars) below.
        </p>

        <!-- Success Notification (if any) -->
        @if (session('status'))
            <div class="mb-3 text-center text-green-400 font-semibold">
                {{ session('status') }}
            </div>
        @endif

        <!-- Form Reset Password -->
        <form action="{{ route('admin.reset-password.update') }}" method="POST">
            @csrf

            <!-- Old Password -->
            <div class="mt-2">
                <label 
                  for="old_password" 
                  class="block text-[22px] sm:text-[28px] md:text-[34px] text-putih mb-1.5"
                >
                    Old Password
                </label>
                <input
                  type="password"
                  id="old_password"
                  name="old_password"
                  placeholder="Enter your old password"
                  class="block w-full h-[48px] sm:h-[52px] md:h-[56px] rounded-[25px] px-6 
                         text-biru-tua focus:outline-none focus:ring-2 
                         focus:ring-biru-tua/50 shadow-sm placeholder-gray-400 
                         transition-all text-base sm:text-lg md:text-xl"
                  required
                />
                @error('old_password')
                    <p class="text-red-300 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- New Password -->
            <div class="mt-4">
                <label
                  for="password"
                  class="block text-[22px] sm:text-[28px] md:text-[34px] text-putih mb-1.5"
                >
                    New Password
                </label>
                <input
                  type="password"
                  id="password"
                  name="password"
                  placeholder="Enter your new password"
                  class="block w-full h-[48px] sm:h-[52px] md:h-[56px] rounded-[25px] px-6 
                         text-biru-tua focus:outline-none focus:ring-2 
                         focus:ring-biru-tua/50 shadow-sm placeholder-gray-400 
                         transition-all text-base sm:text-lg md:text-xl"
                  required
                />
                @error('password')
                    <p class="text-red-300 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm New Password -->
            <div class="mt-4">
                <label
                  for="password_confirmation"
                  class="block text-[22px] sm:text-[28px] md:text-[34px] text-putih mb-1.5"
                >
                    Confirm Password
                </label>
                <input
                  type="password"
                  id="password_confirmation"
                  name="password_confirmation"
                  placeholder="Re-type your new password"
                  class="block w-full h-[48px] sm:h-[52px] md:h-[56px] rounded-[25px] px-6 
                         text-biru-tua focus:outline-none focus:ring-2 
                         focus:ring-biru-tua/50 shadow-sm placeholder-gray-400 
                         transition-all text-base sm:text-lg md:text-xl"
                  required
                />
            </div>
        
            <!-- Submit Button -->
            <div class="flex justify-center mt-6">
                <button 
                  type="submit"
                  class="w-[160px] sm:w-[190px] md:w-[210px] h-[55px] sm:h-[60px] md:h-[65px] 
                         bg-biru-tua rounded-[25px] flex items-center justify-center
                         transition duration-300 hover:bg-blue-700"
                >
                    <span 
                      class="text-white font-im-fell-english leading-[35px] sm:leading-[40px] md:leading-[46px]
                             text-xl sm:text-2xl md:text-[36px]"
                    >
                        Save
                    </span>
                </button>
            </div>
        </form>
    </div>

    <!-- Footer Text -->
    <div class="mt-12 md:mt-1 lg:mt-2 mb-12 md:mb-1 lg:mb-2">
        <p 
          class="text-white text-center sm:mt-8
                 text-2xl sm:text-3xl md:text-2xl"
        >
            Discover your light within
        </p>
    </div>
</div>
@endsection
