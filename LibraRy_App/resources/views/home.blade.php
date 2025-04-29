<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: false }" :class="darkMode ? 'dark' : ''">

<head>
    <x-partials.head />
</head>

<body
    class="font-body bg-light-bg dark:bg-dark-bg text-light-text dark:text-dark-text transition-colors duration-300">
    <!-- Header -->
    <x-partials.nav />

    <!-- Hero Section -->
    <section class="relative h-screen flex items-center justify-center bg-cover bg-center"
        style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('../images/home_creatie.jpg');">
        <div class="text-center px-4" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 500)">
            <h2 class="text-4xl md:text-5xl text-white font-bold mb-8 transition-all duration-1000"
                :class="shown ? 'opacity-100 transform translate-y-0' : 'opacity-0 transform translate-y-10'">
                Découvrez, empruntez, et achetez vos livres préférés en ligne
            </h2>
            <div class="space-x-4">
                <a href="#"
                    class="inline-block px-8 py-3 bg-light-primary dark:bg-dark-primary text-white rounded-full hover:transform hover:-translate-y-1 transition-all duration-300">S'inscrire</a>
                <a href="#"
                    class="inline-block px-8 py-3 border-2 border-white text-white rounded-full hover:bg-light-bg hover:text-light-primary dark:hover:text-dark-primary transition-all duration-300">Explorer
                    le catalogue</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 px-4" x-data="{ activeFeature: null }">
        <div class="max-w-7xl mx-auto">
            <h3 class="text-3xl font-bold text-center mb-16" x-intersect="$el.classList.add('animate-fade-in-up')">Nos
                Services</h3>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="feature-card p-6 rounded-xl bg-light-primary/5 dark:bg-dark-primary/5 transform hover:-translate-y-2 transition-all duration-300"
                    @mouseenter="activeFeature = 1" @mouseleave="activeFeature = null">
                    <div class="text-4xl mb-4 text-light-primary dark:text-dark-primary">📚</div>
                    <h4 class="text-xl font-bold mb-4">Emprunt Digital</h4>
                    <p>Accédez à des milliers de livres numériques instantanément</p>
                </div>
                <div class="feature-card p-6 rounded-xl bg-light-primary/5 dark:bg-dark-primary/5 transform hover:-translate-y-2 transition-all duration-300"
                    @mouseenter="activeFeature = 2" @mouseleave="activeFeature = null">
                    <div class="text-4xl mb-4 text-light-primary dark:text-dark-primary">🎧</div>
                    <h4 class="text-xl font-bold mb-4">Livres Audio</h4>
                    <p>Écoutez vos livres préférés où que vous soyez</p>
                </div>
                <div class="feature-card p-6 rounded-xl bg-light-primary/5 dark:bg-dark-primary/5 transform hover:-translate-y-2 transition-all duration-300"
                    @mouseenter="activeFeature = 3" @mouseleave="activeFeature = null">
                    <div class="text-4xl mb-4 text-light-primary dark:text-dark-primary">💳</div>
                    <h4 class="text-xl font-bold mb-4">Achat Facile</h4>
                    <p>Achetez vos livres en quelques clics</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Books Section -->
    <section class="py-20 px-4 bg-light-primary/5 dark:bg-dark-primary/5">
        <div class="max-w-7xl mx-auto">
            <h3 class="text-3xl font-bold text-center mb-16">Livres Populaires</h3>
            <div class="grid md:grid-cols-4 gap-8">
                @foreach ($books as $book)
                <div
                    class="book-card bg-light-bg dark:bg-dark-bg rounded-lg overflow-hidden shadow-lg transform hover:scale-105 transition-all duration-300">
                    <img src="{{ $book->photo ? asset('storage/' . $book->photo) : asset('images/default-avatar.jpg') }}" alt="{{ $book->title }} by {{ $book->author }}" class="w-full h-64 object-cover">
                    <div class="p-4">
                        <h4 class="font-bold mb-2">{{ $book->title }}</h4>
                        <p class="text-sm mb-2">{{ $book->author }}</p>
                        <button
                            class="w-full bg-light-primary dark:bg-dark-primary text-white py-2 rounded-md hover:opacity-90">
                            Emprunter
                        </button>
                    </div>
                </div>

                @endforeach
                <!-- Répéter pour les autres livres -->
            </div>
        </div>
    </section>

    <!-- À Propos Section -->
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
                        <li class="flex items-center">
                            <span class="text-light-primary dark:text-dark-primary mr-2">✓</span>
                            Livraison gratuite partout en France
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

    <!-- Contact Section avec Map -->
    <section class="py-20 px-4 bg-light-primary/5 dark:bg-dark-primary/5">
        <div class="max-w-7xl mx-auto">
            <h3 class="text-3xl font-bold text-center mb-16">Contactez-nous</h3>
            <div class="grid md:grid-cols-2 gap-12">
                <div class="space-y-6">
                    <form class="space-y-4">
                        <div>
                            <label class="block mb-2">Nom</label>
                            <input type="text"
                                class="w-full p-2 rounded-md border border-light-primary/20 dark:border-dark-primary/20 bg-light-bg/50 focus:outline-2 focus:outline-light-primary dark:bg-dark-bg">
                        </div>
                        <div>
                            <label class="block mb-2">Email</label>
                            <input type="email"
                                class="w-full p-2 rounded-md border border-light-primary/20 dark:border-dark-primary/20 bg-light-bg/50 focus:outline-2 focus:outline-light-primary dark:bg-dark-bg">
                        </div>
                        <div>
                            <label class="block mb-2">Message</label>
                            <textarea rows="4"
                                class="resize-none w-full p-2 rounded-md border border-light-primary/20 dark:border-dark-primary/20 bg-light-bg/50 focus:outline-2 focus:outline-light-primary dark:bg-dark-bg"></textarea>
                        </div>
                        <button
                            class="w-full bg-light-primary dark:bg-dark-primary text-white py-3 rounded-md hover:opacity-90 transition-all duration-300">
                            Envoyer
                        </button>
                    </form>
                </div>
                <div class="h-96 rounded-lg overflow-hidden shadow-xl">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d6228.234113204288!2d-2.929625476032462!3d35.17465217422625!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sfr!2sma!4v1744988392287!5m2!1sfr!2sma"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <x-partials.footer />
</body>

</html>
