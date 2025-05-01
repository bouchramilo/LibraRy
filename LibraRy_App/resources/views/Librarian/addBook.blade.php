@extends('layouts.admin-layout')

@section('title', 'Tableau de bord')
@section('header', 'Tableau de bord')

@section('content')
    <div class="flex min-h-screen">

        <!-- Main Content -->
        <main class="flex-1">
            <!-- Toggle Button -->
            {{-- <button id="sidebarToggle"
                class="fixed top-4 left-4 z-30 p-2 rounded-lg bg-light-primary/20 dark:bg-dark-primary/20 md:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button> --}}

            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="flex justify-between items-center my-4 mx-1">
                    <h1 class="text-3xl font-bold py-4 pt-8">Ajouter un Nouveau Livre</h1>
                </div>

                <!-- Form -->
                <form id="addBookForm" class="bg-white/5 dark:bg-black/5 rounded-xl p-6 shadow-lg space-y-4"
                    action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <!-- Titre et Auteur -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <x-label class="block text-sm font-medium mb-2" for="title">Titre</x-label>
                            <x-input-text type="text" id="title" name="title" required />
                            @error('title')
                                <div>
                                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <x-label class="block text-sm font-medium mb-2" for="author">Auteur</x-label>
                            <x-input-text type="text" id="author" name="author" required />
                            @error('author')
                                <div>
                                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Résumé -->
                    <div class="form-group">
                        <x-label class="block text-sm font-medium mb-2" for="resume">Résumé</x-label>
                        <x-textarea id="summary" name="resume" rows="4" required></x-textarea>
                        @error('resume')
                            <div>
                                <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>

                    <!-- Photo de couverture -->
                    <div class="form-group">
                        <x-label class="block text-sm font-medium mb-2" for="cover">Photo de couverture</x-label>
                        <div class="flex items-center space-x-4">
                            <div class="flex-1">
                                <x-input-text type="file" id="cover" name="photo" accept="image/*" />
                            </div>
                            <div id="imagePreview"
                                class="hidden w-32 h-32 rounded-lg overflow-hidden bg-light-primary/10 dark:bg-dark-primary/10">
                                <img src="" alt="Preview" class="w-full h-full object-cover">
                            </div>
                            @error('photo')
                                <div>
                                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Informations techniques -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="form-group">
                            <x-label class="block text-sm font-medium mb-2" for="pages">Nombre de pages</x-label>
                            <x-input-text type="number" id="pages" name="nbr_pages" required min="1" />
                            @error('nbr_pages')
                                <div>
                                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <x-label class="block text-sm font-medium mb-2" for="publishDate">Date d'édition</x-label>
                            <x-input-text type="date" id="publishDate" name="date_edition" required />
                            @error('date_edition')
                                <div>
                                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <x-label class="block text-sm font-medium mb-2" for="isbn">ISBN</x-label>
                            <x-input-text type="text" id="isbn" name="isbn" required />
                            @error('isbn')
                                <div>
                                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Langue et Catégorie -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <x-label class="block text-sm font-medium mb-2" for="language">Langue</x-label>
                            <x-select id="language" name="language" required
                                class="bg-light-primary/10 dark:bg-dark-primary/10" :options="[
                                    'Français' => 'Français',
                                    'Anglais' => 'Anglais',
                                    'Espagnol' => 'Espagnol',
                                    'Arabe' => 'Arabe',
                                ]">
                            </x-select>
                            @error('language')
                                <div>
                                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                        {{-- Categories Selector --}}
                        <div class="form-group relative " x-data="{
                            open: false,
                            selectedItems: [],
                            categories: {{ json_encode($categories) }},
                            toggleSelection(id, name) {
                                if (this.selectedItems.includes(id)) {
                                    this.selectedItems = this.selectedItems.filter(item => item !== id);
                                } else {
                                    this.selectedItems.push(id);
                                }
                            },
                            getSelectedNames() {
                                return this.selectedItems.map(id => this.categories[id]);
                            }
                        }">
                            <x-label class="block text-sm font-medium mb-2" for="categories">Catégories</x-label>

                            <!-- Input visible -->
                            <div @click="open = !open"
                                class="cursor-pointer w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 flex items-center justify-between border-light-primary/20 dark:border-dark-primary/20 bg-white/5 dark:bg-black/5 focus:ring-2  focus:ring-light-accent dark:focus:ring-dark-accent focus:outline-none focus:border-b-0 transition-all duration-300">
                                <template x-if="selectedItems.length === 0">
                                    <span class="text-gray-400">Sélectionnez des catégories...</span>
                                </template>
                                <div x-show="selectedItems.length > 0" class="flex flex-wrap gap-1">
                                    <template x-for="id in selectedItems" :key="id">
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-100 rounded-full">
                                            <span x-text="categories[id]"></span>
                                            <button @click.stop="toggleSelection(id, categories[id])"
                                                class="ml-1 text-blue-600 dark:text-blue-300 hover:text-blue-800">×</button>
                                        </span>
                                    </template>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 transition-transform duration-200"
                                    :class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>

                            <!-- Options dropdown -->
                            <div x-show="open" @click.outside="open = false" x-transition
                                class="absolute z-10 mt-1 w-full max-h-60 overflow-auto rounded-md bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700">
                                <template x-for="(name, id) in categories" :key="id">
                                    <div @click="toggleSelection(id, name)"
                                        class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer flex items-center"
                                        :class="{ 'bg-gray-100 dark:bg-gray-700': selectedItems.includes(id) }">
                                        <input type="checkbox" :checked="selectedItems.includes(id)"
                                            class="mr-2 rounded text-blue-600 focus:ring-blue-500">
                                        <span x-text="name"></span>
                                    </div>
                                </template>
                            </div>

                            <!-- Hidden inputs for form submission -->
                            <template x-for="id in selectedItems" :key="id">
                                <input type="hidden" name="categories[]" :value="id">
                            </template>

                            @error('categories')
                                <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <!-- Prix -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- <div class="form-group">
                            <x-label class="block text-sm font-medium mb-2" for="salePrice">Prix de vente (€)</x-label>
                            <x-input-text type="number" id="salePrice" name="prix_vente" required min="0"
                                step="0.01" />
                            @error('prix_vente')
                                <div>
                                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                </div>
                            @enderror
                        </div> --}}
                        <div class="form-group">
                            <x-label class="block text-sm font-medium mb-2" for="borrowPrice">Prix d'emprunt (€)</x-label>
                            <x-input-text type="number" id="borrowPrice" name="prix_emprunte" required min="0"
                                step="0.01" />
                            @error('prix_emprunte')
                                <div>
                                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <x-secondary-button type="button" onclick="window.history.back()">
                            Annuler
                        </x-secondary-button>
                        <x-primary-button type="submit">
                            Ajouter le livre
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </main>
    </div>
@endsection
