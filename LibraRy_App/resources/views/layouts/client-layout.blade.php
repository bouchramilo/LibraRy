<!DOCTYPE html>
<html lang="en">

<head>
    <x-partials.head />
    
</head>

<body
    class="font-body bg-light-background dark:bg-dark-background text-light-text dark:text-dark-text transition-colors duration-300">
    <x-partials.nav />

    <main class="max-w-7xl mx-auto">
        @yield('content')
    </main>

    <x-partials.footer />
</body>

</html>
