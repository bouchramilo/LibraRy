<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: false }" :class="darkMode ? 'dark' : ''">

<head>
    <x-partials.head />
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>

<body
    class="font-body bg-light-background dark:bg-dark-background text-light-text dark:text-dark-text transition-colors duration-300">
    {{-- <!-- Header --> --}}
    {{-- <x-partials.nav /> --}}
    <main class="min-h-screen items-center justify-center px-4 py-28 flex-grow container mx-auto">
page forgot password
    </main>
    {{-- <!-- Footer --> --}}
    {{-- <x-partials.footer /> --}}
</body>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,
        easing: 'ease';
        once: true,
    });
</script>

</html>
