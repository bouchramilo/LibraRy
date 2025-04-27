@extends('layouts.client-layout')

@section('title', 'LibraRy - Catalogue')
@section('header', 'LibraRy - Catalogue')

@section('content')

    <main class="flex-grow container mx-auto px-4 py-8 pt-20 pb-16 sm:px-6 lg:px-8 max-w-7xl min-h-screen">
        <div class="mb-8">
            <h1 class="text-3xl font-heading font-bold mb-6">Catalogue des Livres</h1>

            <form method="GET" action="{{ route('client.catalogue') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    {{-- Champ de recherche --}}
                    <div class="relative flex-grow">
                        <x-input-text name="search" type="text" placeholder="Rechercher un livre..." class="pl-10"
                            value="{{ request('search') }}" />
                        <i
                            class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-light-text/50 dark:text-dark-text/50"></i>
                    </div>

                    {{-- Sélecteur de catégorie --}}
                    <x-select id="category_id" name="category_id" placeholder="Toutes les catégories" :options="$categories"
                        :selected="request('category_id')" />

                    {{-- Sélecteur de livre --}}
                    <x-select id="book_id" name="book_id" placeholder="Tous les livres" :options="$options"
                        :selected="request('book_id')" />

                    {{-- Boutons --}}
                    <div class="flex justify-end gap-2">
                        @if (request('search') || request('book_id') || request('category_id'))
                            <a href="{{ route('client.catalogue') }}"
                                class="px-6 py-2 rounded-lg bg-light-primary/10 dark:bg-dark-primary/10 hover:bg-light-primary/20 dark:hover:bg-dark-primary/20 transition-colors">
                                Réinitialiser
                            </a>
                        @endif
                        <x-primary-button type="submit" class="w-full">
                            Appliquer
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-6">
            @foreach ($exemplaires as $exemplaire)
                <div
                    class="bg-white dark:bg-dark-primary/10 border border-light-text/10 dark:border-dark-text/10 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col sm:flex-row">
                    <!-- Image - Prend toute la largeur sur mobile, fixe sur desktop -->
                    <div class="w-full sm:w-32 md:w-40 lg:w-48 h-48 sm:h-auto">
                        <a href="/exemplaire-datails"><img
                                src="{{ $exemplaire->book->photo ? asset('storage/' . $exemplaire->book->photo) : asset('images/default-avatar.jpg') }}"
                                alt="{{ $exemplaire->book->title }} by {{ $exemplaire->book->author }}"
                                class="w-full h-full object-cover rounded-lg"></a>
                    </div>

                    <!-- Contenu - Adapte sa largeur en fonction de l'écran -->
                    <div class="p-4 flex-1 flex flex-col">
                        <h3 class="font-bold text-xl mb-2 line-clamp-2">{{ $exemplaire->book->title }}</h3>
                        <p class="text-light-text/70 dark:text-dark-text/70 mb-1">{{ $exemplaire->book->author }}</p>
                        <p class="text-light-text/70 dark:text-dark-text/70 mb-1 text-sm">Code:
                            {{ $exemplaire->code_serial_exemplaire }}</p>

                        <!-- Badge de disponibilité -->
                        <div class="mb-4 mt-2">
                            <span
                                class="inline-block px-2 py-1 text-xs font-semibold rounded-full
                                {{ $exemplaire->disponible ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $exemplaire->disponible ? 'Disponible' : 'Indisponible' }}
                            </span>
                        </div>

                        <!-- Boutons - Empilement vertical sur petits écrans -->
                        <div class="mt-auto flex flex-col sm:flex-row gap-2">
                            {{-- <button class="flex-1 sm:flex-none text-center rounded-md text-light-accent underline underline-offset-2 border-0 dark:border-dark-text/20 py-2 hover:bg-light-text/10 dark:hover:bg-dark-text/10">
                                Détails
                            </button> --}}
                            <button
                                class="flex-1 rounded-md border border-light-primary dark:border-dark-primary text-light-primary dark:text-dark-primary py-2 hover:bg-light-primary/10 dark:hover:bg-dark-primary/10">
                                Emprunter
                            </button>
                            <button
                                class="flex-1 rounded-md bg-light-primary dark:bg-dark-primary text-white py-2 hover:opacity-90">
                                Acheter
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 flex justify-center">
            {{ $exemplaires->links('vendor.pagination.default') }}
        </div>
    </main>

@endsection
