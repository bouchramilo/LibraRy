<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: false }" :class="darkMode ? 'dark' : ''">


<head>
    <x-partials.head />
</head>

<body class="font-body bg-light-bg dark:bg-dark-bg text-light-text dark:text-dark-text transition-colors duration-300">
    <x-partials.nav />
    {{-- Conteun principale  --}}
    <main class="max-w-7xl mx-auto py-12">
        @yield('content')
    </main>

    <x-partials.footer />
</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const darkModeToggle = document.getElementById('darkModeToggle');
        const html = document.documentElement;

        const isDarkMode = localStorage.getItem('darkMode') === 'true';
        if (isDarkMode) {
            html.classList.add('dark');
        }

        darkModeToggle.addEventListener('click', function() {
            html.classList.toggle('dark');
            localStorage.setItem('darkMode', html.classList.contains('dark'));
        });


    });
</script>

</html>
