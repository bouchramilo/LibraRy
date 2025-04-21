@extends('layouts.admin-layout')

@section('title', 'Tableau de bord')
@section('header', 'Tableau de bord')

@section('content')
    <div class="max-w-7xl mx-auto" x-data="{
        open: false,
        selectedCategoryId: null,
        selectedCategoryName: '',
        editCategory(categoryId, categoryName) {
            this.selectedCategoryId = categoryId;
            this.selectedCategoryName = categoryName;
            this.open = true;
            // Focus sur le champ après l'ouverture du modal
            this.$nextTick(() => document.getElementById('editCategoryName').focus());
        }
    }">
        <!-- Header -->
        <div class="my-8">
            <h1 class="text-3xl font-bold mb-6">Gestion des Catégories</h1>

            <!-- Add Category Form -->
            <form id="addCategoryForm" class="bg-white/5 dark:bg-black/5 p-6 rounded-xl shadow-lg"
                action="{{ route('manage.categories.store') }}" method="POST" x-data="{ submitting: false }"
                @submit.prevent="submitting = true; $el.submit()">
                @csrf

                <div class="flex flex-col md:flex-row gap-4">
                    <x-input-text type="text" id="categoryName" name="category" placeholder="Nom de la catégorie"
                        required class="w-full md:w-auto flex-grow" />

                    <x-primary-button x-bind:disabled="submitting">
                        <span x-show="!submitting">Ajouter</span>
                        <span x-show="submitting" class="flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            En cours...
                        </span>
                    </x-primary-button>
                </div>

                @error('category')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </form>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($categories as $category)
                <div
                    class="bg-white/5 dark:bg-black/5 rounded-xl shadow-lg p-6 hover:transform hover:scale-105 transition-all duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-bold">{{ $category->category }}</h3>
                        <div class="flex space-x-2">
                            <!-- Edit Button -->
                            <button @click="editCategory({{ $category->id }}, '{{ addslashes($category->category) }}')"
                                class="p-2 rounded-lg hover:bg-light-primary/10 dark:hover:bg-dark-primary/10 text-yellow-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </button>

                            <!-- Delete Form -->
                            <form action="{{ route('manage.categories.delete', $category->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="p-2 rounded-lg hover:bg-light-primary/10 dark:hover:bg-dark-primary/10 text-red-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm">
                        <p class="opacity-75">Ajoutée le {{ $category->created_at->format('d/m/Y') }}</p>
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-light-primary dark:text-dark-primary" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                            <span>{{ $category->books_count ?? 0 }} livres</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Modal de modification -->
        <div x-show="open" @click.outside="open = false"
            class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50" x-transition>
            <div class="bg-light-bg dark:bg-dark-bg p-6 rounded-xl w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">Modifier la catégorie</h2>

                <form method="POST" x-bind:action="'{{ route('manage.categories.update', '') }}/' + selectedCategoryId"
                    x-data="{ submitting: false }" @submit.prevent="submitting = true; $el.submit()">

                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <x-input-text type="text" id="editCategoryName" x-model="selectedCategoryName" name="category"
                            placeholder="Nom de la catégorie" required class="w-full" />
                        @error('category')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <x-secondary-button @click="open = false" type="button">
                            Annuler
                        </x-secondary-button>

                        <x-primary-button x-bind:disabled="submitting">
                            <span x-show="!submitting">Enregistrer</span>
                            <span x-show="submitting" class="flex items-center justify-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                En cours...
                            </span>
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="mt-6 flex justify-between items-center w-full">
        {{ $categories->links('vendor.pagination.default') }}
    </div>
@endsection
