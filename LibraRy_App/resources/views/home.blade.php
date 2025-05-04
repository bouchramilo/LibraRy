<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: false }" :class="darkMode ? 'dark' : ''">

<head>
    <x-partials.head />
</head>

<body class="font-body bg-light-bg dark:bg-dark-bg text-light-text dark:text-dark-text transition-colors duration-300">
    {{-- Header --}}
    <x-partials.nav />

    {{-- Hero Section --}}
    <section class="relative h-screen flex items-center justify-center bg-cover bg-center"
        style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('../images/home_creatie.jpg');">
        <div class="text-center px-4" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 500)">
            <h2 class="text-4xl md:text-5xl text-white font-bold mb-8 transition-all duration-1000"
                :class="shown ? 'opacity-100 transform translate-y-0' : 'opacity-0 transform translate-y-10'">
                Découvrez, et empruntez vos livres préférés en ligne
            </h2>
            <div class="space-x-4">
                @guest
                    <a href="{{ route('auth.register.show') }}"
                        class="inline-block px-8 py-3 bg-light-primary dark:bg-dark-primary text-white rounded-full hover:transform hover:-translate-y-1 transition-all duration-300">
                        S'inscrire
                    </a>
                @endguest
                <a href="#populare"
                    class="inline-block px-8 py-3 border-2 border-white text-white rounded-full hover:bg-light-bg hover:text-light-primary dark:hover:text-dark-primary transition-all duration-300">
                    Explorer le catalogue
                </a>
            </div>
        </div>
    </section>



    {{-- Popular Books Section --}}
    <section id="populare" class="py-20 px-4 bg-light-primary/5 dark:bg-dark-primary/5">
        <div class="max-w-7xl mx-auto">
            <h3 class="text-3xl font-bold text-center mb-16">Livres Populaires</h3>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($books as $book)
                    <div
                        class="book-card bg-light-bg dark:bg-dark-bg rounded-lg overflow-hidden shadow-lg transform hover:scale-105 transition-all duration-300">
                        <img src="{{ $book->photo ? asset('storage/' . $book->photo) : asset('images/default-avatar.jpg') }}"
                            alt="{{ $book->title }} by {{ $book->author }}" class="w-full h-96 object-cover">
                        <div class="p-4">
                            <h4 class="font-bold mb-2">{{ $book->title }}</h4>
                            <p class="text-sm mb-2">{{ $book->author }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- À Propos Section --}}
    <section class="py-20 px-4" x-data="{ shown: false }" x-intersect="shown = true">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h3 class="text-3xl font-bold" :class="shown ? 'animate-fade-in-left' : ''">À Propos de BiblioTech
                    </h3>
                    <p class="text-lg">Fondée en 2024, BiblioTech est née de la passion pour la lecture et de la
                        volonté
                        de rendre la littérature accessible à tous. Notre plateforme combine tradition et modernité pour
                        offrir une expérience de lecture unique.</p>
                    <ul class="space-y-4">
                        <li class="flex items-center">
                            <span class="text-light-primary dark:text-dark-primary mr-2">✓</span>
                            Plus de 100,000 livres disponibles
                        </li>
                        <li class="flex items-center">
                            <span class="text-light-primary dark:text-dark-primary mr-2">✓</span>
                            Service client 24/7
                        </li>

                    </ul>
                </div>
                <div class="relative">
                    <img src="../images/Imagem de IA generativa de estantes em uma grande biblioteca em uma escola _ imagem Premium gerada com IA.jpg"
                        alt="Notre bibliothèque" class="rounded-lg shadow-xl">
                </div>
            </div>
        </div>
    </section>

    {{-- Contact Section avec Map --}}
    <section class="py-20 px-4 bg-light-primary/5 dark:bg-dark-primary/5">
        <div class="max-w-7xl mx-auto">
            <h3 class="text-3xl font-bold text-center mb-16">Visitez-nous</h3>

            <div class="h-96 rounded-lg overflow-hidden shadow-xl w-full">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d6228.234113204288!2d-2.929625476032462!3d35.17465217422625!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sfr!2sma!4v1744988392287!5m2!1sfr!2sma"
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                </iframe>
            </div>
        </div>
    </section>

    {{-- Footer --}}
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
