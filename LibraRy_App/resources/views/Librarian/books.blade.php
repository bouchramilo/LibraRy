@extends('layouts.admin-layout')

@section('title', 'Tableau de bord')
@section('header', 'Tableau de bord')

@section('content')

    <!-- Main Content -->
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-light-bg dark:bg-dark-bg p-6" x-data="{
        showModal: false,
        bookToDelete: { id: null, title: '' },
        openModal(id, title) {
            this.bookToDelete = { id, title };
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        }
    }">

        <!-- Messages de statut -->
        <x-messages></x-messages>
        <!-- Messages de statut -->

        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold">Gestion des Livres</h1>
                <a href="/admin/books/add"
                    class="px-4 py-2 bg-light-primary dark:bg-dark-primary text-white rounded-lg hover:opacity-90 transition-all duration-300">
                    Ajouter un livre
                </a>
            </div>

            <!-- Filters -->
            <!-- Search and Filter Section -->
            <div class="bg-background dark:bg-dark-bg p-4 md:p-6 rounded-lg shadow-lg mb-6 md:mb-8">
                <form method="GET" action="{{ route('librarian.books.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search Bar -->
                        <div class="col-span-1 md:col-span-1">
                            <x-input-text name="search" type="text" placeholder="Rechercher un livre..."
                                value="{{ request('search') }}" />
                        </div>

                        <!-- Category Filter -->
                        <div class="col-span-1">
                            <x-select id="category_id" name="category_id" placeholder="Filtrer par catégorie"
                                :options="$categories" :selected="request('category_id')" />
                        </div>

                        <!-- Language Filter -->
                        <div class="col-span-1">
                            <x-select id="language" name="language" placeholder="Filtrer par langue" :options="$languages"
                                :selected="request('language')" />
                        </div>
                    </div>

                    <div class="mt-4 flex justify-between items-center">
                        <div class="flex space-x-2">
                            @if (request()->anyFilled(['search', 'category_id', 'language']))
                                <a href="{{ route('librarian.books.index') }}"
                                    class="px-6 py-2 rounded-lg bg-light-primary/10 dark:bg-dark-primary/10 hover:bg-light-primary/20 dark:hover:bg-dark-primary/20 transition-colors">
                                    Réinitialiser les filtres
                                </a>
                            @endif
                        </div>
                        <x-primary-button type="submit">
                            Appliquer les filtres
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Books Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Example Book Card -->
                @foreach ($books as $book)
                    <div
                        class="bg-white/5 dark:bg-black/5 rounded-xl shadow-lg overflow-hidden hover:transform hover:shadow-light-primary hover:shadow-lg transition-all duration-300">
                        <img src="{{ $book->photo ? asset('storage/' . $book->photo) : asset('images/default-avatar.jpg') }}"
                            alt="{{ $book->title }}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="font-bold text-xl mb-1">{{ $book->title }}</h3>
                                    <p class="text-sm opacity-75">{{ $book->author }}</p>
                                </div>
                                <span class="px-2 py-1 rounded-full text-sm bg-green-500/10 text-green-500">
                                    Disponible
                                </span>
                            </div>
                            <div class="space-y-2 text-sm">
                                <p><span class="opacity-75">ISBN:</span> {{ $book->isbn }}</p>
                                <p><span class="opacity-75">Catégorie:</span>
                                    @foreach ($book->categories as $category)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-1">
                                            {{ $category->category }}
                                        </span>
                                    @endforeach
                                </p>
                                <p><span class="opacity-75">Quantité:</span> 5</p>
                            </div>
                            <div class="flex justify-end space-x-2 mt-4">
                                <a href="{{ route('admin.books.show', $book->id) }}">
                                    <button
                                        class="p-2 rounded-lg hover:bg-light-primary/10 dark:hover:bg-dark-primary/10 text-light-accent dark:text-dark-accent">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>
                                </a>
                                <a href="{{ route('admin.books.edit', $book->id) }}">
                                    <button
                                        class="p-2 rounded-lg hover:bg-light-primary/10 dark:hover:bg-dark-primary/10 text-yellow-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>
                                </a>
                                {{-- button de suppression pour un model de la comfirmation de suppression  --}}
                                <button @click="openModal('{{ $book->id }}', '{{ $book->title }}')"
                                    class="p-2 rounded-lg hover:bg-light-primary/10 dark:hover:bg-dark-primary/10 text-red-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Modal de confirmation -->
        <div x-show="showModal" x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-bold mb-3">Confirmer la suppression</h3>
                <p>Voulez-vous vraiment supprimer le livre :</p>
                <p class="font-semibold mt-2" x-text="bookToDelete.title"></p>
                <p class="text-sm text-gray-500 mt-1">ID: <span x-text="bookToDelete.id"></span></p>

                <div class="flex justify-end space-x-3 mt-6">
                    <button @click="closeModal" class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600">
                        Annuler
                    </button>
                    <form :action="'/admin/books/delete/' + bookToDelete.id" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
