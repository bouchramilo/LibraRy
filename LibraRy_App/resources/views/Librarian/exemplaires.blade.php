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

        <!-- Main Content -->
        <div class="ml-0 p-4 md:p-8 w-full">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 md:mb-8 gap-4">
                <h1 class="text-2xl md:text-3xl font-heading font-bold">Gestion des Exemplaires</h1>
                <a href="{{ route('librarian.exemplaires.create') }}"><x-primary-button> Ajouter un exemplaire</x-primary-button></a>
            </div>

            <!-- Search and Filter Section -->
            <div class="bg-light-primary/5 dark:bg-dark-bg p-4 md:p-6 rounded-lg shadow-lg mb-6 md:mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search Bar -->
                    <div class="col-span-1 md:col-span-1">
                        <x-input-text type="text" placeholder="Rechercher un exemplaire..." />
                    </div>

                    <!-- Book Title Filter -->
                    <div class="col-span-1">
                        <x-select id="language" name="language" required
                            class="bg-light-primary/10 dark:bg-dark-primary/10" :options="[
                                '1' => 'Le Petit Prince',
                                '2' => 'Le Petit Prince',
                                '3' => 'Le Petit Prince',
                                '4' => 'Le Petit Prince',
                            ]">
                        </x-select>
                    </div>

                    <!-- Author Filter -->
                    <div class="col-span-1">
                        <x-select id="language" name="language" required
                            class="bg-light-primary/10 dark:bg-dark-primary/10" :options="[
                                '1' => 'Antoine de Saint-Exupéry',
                                '2' => 'George Orwell',
                                '3' => 'J.R.R. Tolkien',
                                '4' => 'Khawla Hamdi',
                            ]">
                        </x-select>
                    </div>
                </div>
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
                                class="px-2 py-1 rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-sm">{{ $exemplaire->disponible ? "Disponible" : "non Disponible" }}</span>
                        </td>
                        <td class="px-4 md:px-6 py-4">
                            <button
                                class="text-light-accent hover:text-light-secondary dark:text-dark-accent dark:hover:text-dark-secondary mr-2">Modifier</button>
                            <button class="text-red-500 hover:text-red-700">Supprimer</button>
                        </td>
                    </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection
