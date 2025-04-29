@extends('layouts.client-layout')

@section('title', 'LibraRy - Catalogue')
@section('header', 'LibraRy - Catalogue')

@section('content')

    <main class="flex-grow container mx-auto px-4 py-8 pt-4 pb-16 sm:px-6 lg:px-8 max-w-7xl min-h-screen"
        x-data="{
            showModal: false,
            bookToRent: { id: null, title: '', code: '' },
            openModal(id, title, code) {
                this.bookToRent = { id, title, code };
                this.showModal = true;
            },
            closeModal() {
                this.showModal = false;
            }
        }">

        {{-- messages start --}}
        <x-messages />
        {{-- messages end --}}

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
                    <div class="w-full sm:w-32 md:w-40 lg:w-48 h-48 sm:h-auto">
                        <a href="{{ route('client.catalogue.show', $exemplaire->id) }}"><img
                                src="{{ $exemplaire->book->photo ? asset('storage/' . $exemplaire->book->photo) : asset('images/default-avatar.jpg') }}"
                                alt="{{ $exemplaire->book->title }} by {{ $exemplaire->book->author }}"
                                class="w-full h-full object-cover rounded-lg"></a>
                    </div>

                    <div class="p-4 flex-1 flex flex-col">
                        <h3 class="font-bold text-xl mb-2 line-clamp-2">{{ $exemplaire->book->title }}</h3>
                        <p class="text-light-text/70 dark:text-dark-text/70 mb-1">{{ $exemplaire->book->author }}</p>
                        <p class="text-light-text/70 dark:text-dark-text/70 mb-1 text-sm">Code:
                            {{ $exemplaire->code_serial_exemplaire }}</p>

                        <div class="mb-4 mt-2">
                            <p class="text-light-text/70 dark:text-dark-text/70 mb-1 text-sm">Etat :
                                <span
                                    class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-light-accent/10 text-light-accent">
                                    {{ $exemplaire->etat }}
                                </span>
                            </p>
                        </div>
                        <div class="mb-4 mt-2">
                            <span
                                class="inline-block px-2 py-1 text-xs font-semibold rounded-full
                                {{ $exemplaire->disponible ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $exemplaire->disponible ? 'Disponible' : 'Indisponible' }}
                            </span>
                        </div>

                        <div class="mt-auto flex flex-col sm:flex-row gap-2">

                            @if ($exemplaire->disponible === 1)
                                <x-secondary-button
                                    @click="openModal('{{ $exemplaire->id }}', '{{ $exemplaire->book->title }}', '{{ $exemplaire->code_serial_exemplaire }}' )">
                                    Emprunter
                                </x-secondary-button>
                                <x-primary-button>
                                    Acheter
                                </x-primary-button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 flex justify-center">
            {{ $exemplaires->links('vendor.pagination.default') }}
        </div>

        <!-- Modal de confirmation -->
        <div x-show="showModal" x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white dark:bg-dark-bg rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-bold mb-3">Confirmer l'emprunt</h3>
                <p>Voulez-vous vraiment Emprunter ce livre :</p>
                <p class="font-semibold mt-2" x-text="bookToRent.title"></p>
                <p class="text-sm text-gray-500 mt-1">Code : <span x-text="bookToRent.code"></span></p>

                <div class="flex justify-end space-x-3 mt-6">
                    <x-secondary-button @click="closeModal">
                        Annuler
                    </x-secondary-button>
                    <form :action="'/client/Emprunts/'" method="POST">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="exemplaire_id" :value="bookToRent.id">
                        <x-primary-button type="submit">
                            Emprunter
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </main>

@endsection
