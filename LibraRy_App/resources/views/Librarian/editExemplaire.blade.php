@extends('layouts.admin-layout')

@section('title', 'Modifier Exemplaire')
@section('header', 'Modifier Exemplaire')

@section('content')
    <div class="flex min-h-screen">
        {{-- Main Content --}}
        <main class="flex-1 mx-10">
            {{-- Messages de statut --}}
            <x-messages></x-messages>
            {{-- Messages de statut --}}

            <div class="max-w-7xl mx-auto">
                <div class="flex justify-between items-center my-4 mx-1">
                    <h1 class="text-3xl font-bold py-4 pt-8">Modifier l'Exemplaire #{{ $exemplaire->code_serial_exemplaire }}
                    </h1>
                </div>

                <form id="editExemplaireForm" class="bg-white/5 dark:bg-black/5 rounded-xl p-6 shadow-lg space-y-4"
                    action="{{ route('librarian.exemplaires.update', $exemplaire->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="block text-sm font-medium mb-2" for="book">Livre</label>
                        <x-select id="book" name="book_id" required :options="$options" :selected="$exemplaire->book_id"
                            placeholder="Sélectionnez un livre" />
                        @error('book_id')
                            <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-medium mb-2" for="code_serial_exemplaire">
                            Code Serial Exemplaire
                        </label>
                        <x-input-text type="text" id="code_serial_exemplaire" name="code_serial_exemplaire"
                            value="{{ old('code_serial_exemplaire', $exemplaire->code_serial_exemplaire) }}" required />
                        @error('code_serial_exemplaire')
                            <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-medium mb-2" for="etat">État</label>
                        <x-select id="etat" name="etat" required :options="[
                            'neuf' => 'Neuf',
                            'bon' => 'Bon',
                            'usé' => 'Usé',
                            'endommagé' => 'Endommagé',
                        ]" :selected="old('etat', $exemplaire->etat)" />
                        @error('etat')
                            <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label class="block text-sm font-medium mb-2" for="rayon">Rayon</label>
                            <x-input-text type="text" id="rayon" name="rayon"
                                value="{{ old('rayon', $exemplaire->rayon) }}" required />
                            @error('rayon')
                                <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-medium mb-2" for="etagere">Étagère</label>
                            <x-input-text type="text" id="etagere" name="etagere"
                                value="{{ old('etagere', $exemplaire->etagere) }}" required />
                            @error('etagere')
                                <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('librarian.exemplaires.index') }}"
                            class="px-6 py-2 rounded-lg bg-light-primary/10 dark:bg-dark-primary/10 hover:bg-light-primary/20 dark:hover:bg-dark-primary/20 transition-colors">
                            Annuler
                        </a>
                        <button type="submit"
                            class="px-6 py-2 rounded-lg bg-light-primary dark:bg-dark-primary text-white hover:bg-light-primary/90 dark:hover:bg-dark-primary/90 transition-colors">
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
@endsection
