<div
    x-data="{ show: false, message: '', type: '' }"
    x-show="show"
    x-init="
        @if(session('success'))
            message = '{{ session('success') }}';
            type = 'success';
            show = true;
        @elseif(session('error'))
            message = '{{ session('error') }}';
            type = 'error';
            show = true;
        @endif
        if(show) {
            setTimeout(() => show = false, 5000);
        }
    "
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-[-10px]"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform translate-y-[-10px]"
    class="fixed top-5 right-5 max-w-sm w-full bg-green-500 text-white p-4 rounded-lg shadow-lg flex items-start space-x-3 z-[999]"
    :class="type === 'error' ? 'bg-red-500' : 'bg-green-500'"
>
    <div>
        <svg
            x-show="type === 'success'"
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M5 13l4 4L19 7" />
        </svg>
        <svg
            x-show="type === 'error'"
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M6 18L18 6M6 6l12 12" />
        </svg>
    </div>
    <div class="flex-1">
        <p x-text="message"></p>
    </div>
    <button @click="show = false" class="text-white focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" 
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
