<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: false }" :class="darkMode ? 'dark' : ''">

<head>
    <x-partials.head />
</head>

<body
    class="font-body bg-light-background dark:bg-dark-background text-light-text dark:text-dark-text transition-colors duration-300">
    <!-- Header -->
    <x-partials.nav />




    <section class="py-20 px-4 min-h-[700px] min-w-screen bg-light-primary/5 dark:bg-dark-primary/5 flex flex-col justify-center items-center gap-16">
        <p>404 - Not Found</p>
        <a href="/home"><x-primary-button>Allez au Acceuil</x-primary-button></a>
    </section>


    <!-- Footer -->
    <x-partials.footer />
</body>

</html>
