@extends('layouts.client-layout')

@section('title', 'LibraRy - Catalogue')
@section('header', 'LibraRy - Catalogue')

@section('content')

    <main class="pt-20 pb-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <h1 class="text-3xl font-heading font-bold mb-8 text-light-primary dark:text-dark-primary">Bienvenue, Jean</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-light-secondary/5 dark:bg-dark-secondary/10 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold">Livres empruntés</h3> <i
                        class="fas fa-book text-light-primary dark:text-dark-primary text-xl"></i>
                </div>
                <p class="text-3xl font-bold mt-4">5</p>
            </div>
            <div class="bg-light-secondary/5 dark:bg-dark-secondary/10 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold">En possession</h3>
                    <i class="fas fa-bookmark text-light-primary dark:text-dark-primary text-xl"></i>
                </div>
                <p class="text-3xl font-bold mt-4">2</p>
            </div>
            <div class="bg-light-secondary/5 dark:bg-dark-secondary/10 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold">Prochain retour</h3> <i
                        class="fas fa-calendar text-light-primary dark:text-dark-primary text-xl"></i>
                </div>
                <p class="text-xl font-bold mt-4">15 Mars 2024</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <section class="bg-light-secondary/5 dark:bg-dark-secondary/10 rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Notifications</h2>
                <div class="space-y-4">
                    <div
                        class="flex items-start space-x-4 p-4 bg-light-bg dark:bg-dark-secondary/20 bg-light-secondary/10 rounded-lg">
                        <i class="fas fa-exclamation-circle text-red-500 mt-1"></i>
                        <div>
                            <h4 class="font-semibold">Retour proche</h4>
                            <p class="text-sm">Le livre "Les Misérables" doit être retourné dans 3 jours</p>
                        </div>
                    </div>
                    <div
                        class="flex items-start space-x-4 p-4 bg-light-bg dark:bg-dark-secondary/20 bg-light-secondary/10 rounded-lg">
                        <i class="fas fa-tag text-green-500 mt-1"></i>
                        <div>
                            <h4 class="font-semibold">Promotion</h4>
                            <p class="text-sm">-20% sur tous les romans classiques ce week-end</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-light-secondary/5 dark:bg-dark-secondary/10 rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Activités Récentes</h2>
                <div class="space-y-4">
                    <div class="flex items-center space-x-4"> <img src="../images/img_2.png" alt="Les Misérables"
                            class="w-20 h-30 object-cover rounded">
                        <div>
                            <h4 class="font-semibold">Les Misérables</h4>
                            <p class="text-sm">Emprunté le 1 Mars 2024</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4"> <img src="../images/img_3.png" alt="Le Comte de Monte-Cristo"
                            class="w-20 h-30 object-cover rounded">
                        <div>
                            <h4 class="font-semibold">Le Comte de Monte-Cristo</h4>
                            <p class="text-sm">Retourné le 28 Février 2024</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
            <a href="#"
                class="bg-light-secondary/5 dark:bg-dark-secondary/10 rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                <i class="fas fa-user-circle text-3xl text-light-primary dark:text-dark-primary mb-4"></i>
                <h3 class="font-semibold">Mon Profil</h3>
                <p class="text-sm mt-2">Gérer vos informations personnelles</p>
            </a>
            <a href="#"
                class="bg-light-secondary/5 dark:bg-dark-secondary/10 rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                <i class="fas fa-book-reader text-3xl text-light-primary dark:text-dark-primary mb-4"></i>
                <h3 class="font-semibold">Mes Emprunts</h3>
                <p class="text-sm mt-2">Voir vos livres actuels</p>
            </a>
            <a href="#"
                class="bg-light-secondary/5 dark:bg-dark-secondary/10 rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                <i class="fas fa-shopping-bag text-3xl text-light-primary dark:text-dark-primary mb-4"></i>
                <h3 class="font-semibold">Boutique</h3>
                <p class="text-sm mt-2">Découvrir notre collection</p>
            </a>
            <a href="#"
                class="bg-light-secondary/5 dark:bg-dark-secondary/10 rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                <i class="fas fa-calendar-check text-3xl text-light-primary dark:text-dark-primary mb-4"></i>
                <h3 class="font-semibold">Réservations</h3>
                <p class="text-sm mt-2">Gérer vos réservations</p>
            </a>
        </section>
    </main>
@endsection
