@extends('layouts.admin-layout')

@section('title', 'Tableau de bord')
@section('header', 'Tableau de bord')

@section('content')
    <div class="flex min-h-screen">

        <!-- Main Content -->
        <main class="flex-1 mx-10">
            <!-- Toggle Button -->
            <button id="sidebarToggle"
                class="fixed top-4 left-4 z-30 p-2 rounded-lg bg-light-primary/20 dark:bg-dark-primary/20 md:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="flex justify-between items-center my-6 mx-1">
                    <h1 class="text-3xl font-bold py-4 pt-8">Ajouter un Nouveau Exemplaire</h1>
                </div>

                <!-- Form -->
                <form id="addExemplaireForm" class="bg-white/5 dark:bg-black/5 rounded-xl p-6 shadow-lg space-y-4"
                    action="{{ route('librarian.exemplaires.store') }}" method="POST">
                    @csrf

                    <!-- Livre -->
                    <div class="form-group">
                        <label class="block text-sm font-medium mb-2" for="book">Livre</label>
                        <x-select id="book" name="book_id" required :options="$options"
                            placeholder="Sélectionnez un livre" />
                    </div>

                    <!-- Code Serial Exemplaire -->
                    <div class="form-group">
                        <label class="block text-sm font-medium mb-2" for="code_serial_exemplaire">Code Serial
                            d'exemplaire</label>
                        <x-input-text type="text" id="code_serial_exemplaire"  placeholder="Entrez le code d'exemplaire." name="code_serial_exemplaire" required />
                    </div>

                    <!-- État -->
                    <div class="form-group">
                        <label class="block text-sm font-medium mb-2" for="etat">État</label>
                        <x-select id="etat" name="etat" required  placeholder="Sélectionnez l'état de exemplaire" :options="[
                            'neuf' => 'Neuf',
                            'bon' => 'Bon',
                            'usé' => 'Usé',
                            'endommagé' => 'Endommagé',
                        ]">
                        </x-select>
                    </div>

                    <!-- Emplacement -->
                    {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-6"> --}}
                        <div class="form-group">
                            <label class="block text-sm font-medium mb-2" for="rayon">Rayon</label>
                            <x-input-text type="text" id="rayon" name="rayon" required />
                        </div>
                        <div class="form-group">
                            <label class="block text-sm font-medium mb-2" for="etagere">Étagère</label>
                            <x-input-text type="text" id="etagere" name="etagere" required />
                        </div>
                    {{-- </div> --}}

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="window.history.back()"
                            class="px-6 py-2 rounded-lg bg-light-primary/10 dark:bg-dark-primary/10 hover:bg-light-primary/20 dark:hover:bg-dark-primary/20 transition-colors">
                            Annuler
                        </button>
                        <button type="submit"
                            class="px-6 py-2 rounded-lg bg-light-primary dark:bg-dark-primary text-white hover:bg-light-primary/90 dark:hover:bg-dark-primary/90 transition-colors">
                            Ajouter l'exemplaire
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
@endsection
