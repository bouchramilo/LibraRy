<!DOCTYPE html>
<html lang="en">
<head>
    <x-partials.head />
</head>
<body>
    <x-partials.nav />

    <main>
        {{ $slot }}
    </main>

    <x-partials.footer />
</body>
</html>
