@extends('layouts.admin-layout')

@section('title', 'Tableau de bord')
@section('header', 'Tableau de bord')

@section('content')

    <!-- Main Content -->
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-light-bg dark:bg-dark-bg p-6" x-data="{
        showModal: false,
        exemplaireToDelete: { id: null, title: '', code_serial_exemplaire: '' },
        openModal(id, title, code_serial_exemplaire) {
            this.exemplaireToDelete = { id, title, code_serial_exemplaire };
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        }
    }">

        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition
                class="mb-6 flex items-center p-4 bg-green-50 border-l-4 border-green-500 text-green-700 dark:bg-green-900 dark:bg-opacity-20 dark:border-green-400 dark:text-green-200">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <div class="flex-grow">{{ session('success') }}</div>
                <button @click="show = false"
                    class="text-green-700 dark:text-green-200 hover:text-green-900 dark:hover:text-green-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        <!-- Main Content -->
        <div class="ml-0 p-4 md:p-8 w-full">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 md:mb-8 gap-4">
                <h1 class="text-2xl md:text-3xl font-heading font-bold">Gestion des Exemplaires</h1>
                <a href="{{ route('librarian.exemplaires.create') }}"><x-primary-button> Ajouter un
                        exemplaire</x-primary-button></a>
            </div>

            <!-- Search and Filter Section -->
            <div class="bg-background dark:bg-dark-bg p-4 md:p-6 rounded-lg shadow-lg mb-6 md:mb-8">
                <form method="GET" action="{{ route('librarian.exemplaires.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search Bar -->
                        <div class="col-span-1 md:col-span-1">
                            <x-input-text name="search" type="text" placeholder="Rechercher un exemplaire..."
                                value="{{ request('search') }}" />
                        </div>

                        <!-- Book Title Filter -->
                        <div class="col-span-1">
                            <x-select id="book_id" name="book_id" placeholder="Sélectionnez un livre" :options="$options"
                                :selected="request('book_id')" />
                        </div>
                        <div class=" flex justify-end gap-2">
                            @if (request('search') || request('book_id'))
                                <a href="{{ route('librarian.exemplaires.index') }}" class="px-6 py-2 rounded-lg bg-light-primary/10 dark:bg-dark-primary/10 hover:bg-light-primary/20 dark:hover:bg-dark-primary/20 transition-colors">
                                   Réinitialiser
                                </a>
                            @endif
                            <x-primary-button type="submit" class="w-full">
                                Appliquer les filtres
                            </x-primary-button>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Exemplaires Table -->
            <div class="bg-transparnet/50 dark:bg-dark-bg rounded-lg shadow-lg overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-light-primary/90 dark:bg-dark-primary/90 text-white">
                        <tr>
                            <th class="px-4 md:px-6 py-3 text-left">ID</th>
                            <th class="px-4 md:px-6 py-3 text-left">Titre</th>
                            <th class="px-4 md:px-6 py-3 text-left">Auteur</th>
                            <th class="px-4 md:px-6 py-3 text-left">État</th>
                            <th class="px-4 md:px-6 py-3 text-left">Disponibilité</th>
                            <th class="px-4 md:px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-light-secondary dark:divide-dark-secondary">
                        {{-- +++++++++++++++++++++++++++++++++++ --}}
                        @foreach ($exemplaires as $exemplaire)
                            <tr class="hover:bg-light-secondary/10 dark:hover:bg-dark-secondary/10">
                                <td class="px-4 md:px-6 py-4">{{ $exemplaire->code_serial_exemplaire }}</td>
                                <td class="px-4 md:px-6 py-4">{{ $exemplaire->book->title }}</td>
                                <td class="px-4 md:px-6 py-4">{{ $exemplaire->book->author }}</td>
                                <td class="px-4 md:px-6 py-4">
                                    <span
                                        class="px-2 py-1 rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 text-sm">{{ $exemplaire->etat }}</span>
                                </td>
                                <td class="px-4 md:px-6 py-4">
                                    <span
                                        class="px-2 py-1 rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-sm">{{ $exemplaire->disponible ? 'Disponible' : 'non Disponible' }}</span>
                                </td>
                                <td class="px-4 md:px-6 py-4 ">
                                    <a href="{{ route('librarian.exemplaires.edit', $exemplaire->id) }}">
                                        <button
                                            class="text-light-accent hover:text-light-secondary dark:text-dark-accent dark:hover:text-dark-secondary mr-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>
                                    </a>
                                    <button
                                        @click="openModal('{{ $exemplaire->id }}', '{{ $exemplaire->book->title }}', '{{ $exemplaire->code_serial_exemplaire }}')"
                                        class="p-2 rounded-lg hover:bg-light-primary/10 dark:hover:bg-dark-primary/10 text-red-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        {{-- +++++++++++++++++++++++++++++++++++ --}}
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">
            {{ $exemplaires->appends(request()->query())->links('vendor.pagination.default') }}
        </div>
        {{-- ******************************************************************************************************************************* --}}
        <!-- Modal de confirmation -->
        <div x-show="showModal" x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white dark:bg-dark-bg rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-bold mb-3">Confirmer la suppression</h3>
                <p>Voulez-vous vraiment supprimer l'exemplaire "<span x-text="exemplaireToDelete.title"
                        class="font-bold"></span>" de code "<span x-text="exemplaireToDelete.code_serial_exemplaire"
                        class="font-bold"></span>" :</p>

                <div class="flex justify-end space-x-3 mt-6">
                    <x-secondary-button @click="closeModal">
                        Annuler
                    </x-secondary-button>
                    <form :action="'/admin/exemplaires/delete/' + exemplaireToDelete.id" method="POST">
                        @csrf
                        @method('DELETE')
                        <x-primary-button class="bg-red-500 text-white hover:bg-red-600">
                            Supprimer
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
