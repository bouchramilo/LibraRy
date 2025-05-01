@extends('layouts.client-layout')

@section('title', 'LibraRy - Catalogue')
@section('header', 'LibraRy - Catalogue')

@section('content')

    <main class="pt-10 pb-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <h1 class="text-3xl font-heading font-bold mb-8 text-light-primary dark:text-dark-primary">Bienvenue,
            {{ Auth::user()->first_name }}</h1>

        {{-- partie 1 --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-light-secondary/5 dark:bg-dark-secondary/10 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold">Livres empruntés</h3>
                    <i class="fas fa-book text-light-primary dark:text-dark-primary text-xl"></i>
                </div>
                <p class="text-3xl font-bold mt-4">{{ $book_rented }}</p>
            </div>
            <div class="bg-light-secondary/5 dark:bg-dark-secondary/10 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold">En retard</h3>
                    <i class="fas fa-exclamation-triangle text-light-primary dark:text-dark-primary text-xl"></i>
                </div>
                <p class="text-3xl font-bold mt-4">{{ $overdue_books->count() }}</p>
            </div>
            <div class="bg-light-secondary/5 dark:bg-dark-secondary/10 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold">Prochain retour</h3>
                    <i class="fas fa-calendar text-light-primary dark:text-dark-primary text-xl"></i>
                </div>
                <p class="text-xl font-bold mt-4">{{ $next_return_date }}</p>
            </div>
        </div>

        {{-- partie 2 --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <section class="bg-light-secondary/5 dark:bg-dark-secondary/10 rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Notifications</h2>
                <div class="space-y-4">
                    @if ($overdue_books->isEmpty())
                        <div class="bg-white dark:bg-dark-primary/10 rounded-lg p-8 text-center">
                            Aucune notification pour ce moment
                        </div>
                    @else
                        @foreach ($overdue_books as $late)
                            <div
                                class="flex items-start space-x-4 p-4 bg-light-bg dark:bg-dark-secondary/20 bg-light-secondary/10 rounded-lg">
                                <i class="fas fa-exclamation-circle text-red-500 mt-1"></i>
                                <div>
                                    <h4 class="font-semibold">Retard</h4>
                                    <p class="text-sm">Le livre "{{ $late->exemplaire->book->title }}" est en retard.</p>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
            </section>

            {{-- partie 3 --}}
            <section class="bg-light-secondary/5 dark:bg-dark-secondary/10 rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Activités Récentes</h2>
                <div class="space-y-4">
                    @forelse($recent_activities as $activity)
                        <div class="flex items-center space-x-4">
                            <img src="{{ $activity->exemplaire->book->photo ? asset('storage/' . $activity->exemplaire->book->photo) : asset('images/default-avatar.jpg') }}"
                                alt="{{ $activity->exemplaire->book->title ?? 'Livre inconnu' }}"
                                class="w-20 h-30 object-cover rounded">
                            <div>
                                <h4 class="font-semibold">{{ $activity->exemplaire->book->title ?? 'Livre inconnu' }}</h4>
                                <p class="text-sm">
                                    @if ($activity->date_retour_effectif)
                                        Retourné le
                                        {{ \Carbon\Carbon::parse($activity->date_retour_effectif)->format('d M Y') }}
                                    @else
                                        Emprunté le {{ \Carbon\Carbon::parse($activity->date_emprunt)->format('d M Y') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Aucune activité récente.</p>
                    @endforelse
                </div>
            </section>
        </div>

        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mt-8">
            <a href="{{ route('auth.profile.show') }}"
                class="bg-light-secondary/5 dark:bg-dark-secondary/10 rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                <i class="fas fa-user-circle text-3xl text-light-primary dark:text-dark-primary mb-4"></i>
                <h3 class="font-semibold">Mon Profil</h3>
                <p class="text-sm mt-2">Gérer vos informations personnelles</p>
            </a>
            <a href="{{ route('client.emprunt.show') }}"
                class="bg-light-secondary/5 dark:bg-dark-secondary/10 rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                <i class="fas fa-book-reader text-3xl text-light-primary dark:text-dark-primary mb-4"></i>
                <h3 class="font-semibold">Mes Emprunts</h3>
                <p class="text-sm mt-2">Voir vos livres actuels</p>
            </a>

        </section>
    </main>
@endsection
