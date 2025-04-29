
{{-- success --}}

@if (session('success'))
<div x-data="{
    show: true,
    animateOut: false
}" x-show="show && !animateOut" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-4"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform -translate-y-4" x-init="setTimeout(() => {
        animateOut = true;
        setTimeout(() => show = false, 300);
    }, 3000)"
    class="mb-6 flex items-center p-4 bg-green-50 border-l-4 border-green-500 text-green-700 dark:bg-green-900 dark:bg-opacity-20 dark:border-green-400 dark:text-green-200">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
    </svg>
    <div class="flex-grow">{{ session('success') }}</div>
    <button @click="show = false"
        class="text-green-700 dark:text-green-200 hover:text-green-900 dark:hover:text-green-100">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
@endif

{{-- erreur --}}
@if (session('error'))
<div x-data="{
    show: true,
    animateOut: false
}" x-show="show && !animateOut" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-4"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform -translate-y-4" x-init="setTimeout(() => {
        animateOut = true;
        setTimeout(() => show = false, 300);
    }, 3000)"
    class="mb-6 flex items-center p-4 bg-red-50 border-l-4 border-red-500 text-red-700 dark:bg-red-900 dark:bg-opacity-20 dark:border-red-400 dark:text-red-200">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
    </svg>
    <div class="flex-grow">{{ session('error') }}</div>
    <button @click="show = false"
        class="text-red-700 dark:text-red-200 hover:text-red-900 dark:hover:text-red-100">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
@endif
