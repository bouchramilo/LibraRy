<!DOCTYPE html>
<html lang="en">

<head>
    <x-partials.head />

</head>

<body
    class="font-body bg-light-bg dark:bg-dark-bg text-light-text dark:text-dark-text transition-colors duration-300">
    <x-partials.nav />

    <main class="max-w-7xl mx-auto py-20">
        @yield('content')
    </main>

    <x-partials.footer />
</body>

<script>
    // Fonctions JavaScript pour la gestion des utilisateurs
    document.addEventListener('DOMContentLoaded', function() {

        // Dark Mode Toggle
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
