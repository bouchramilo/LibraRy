@extends('layouts.admin-layout')

@section('title', 'Tableau de bord')
@section('header', 'Tableau de bord')

@section('content')
    <div class="flex min-h-screen md:p-6 p-2">

        <main class="flex-1">
            {{-- Messages de statut --}}
            <x-messages></x-messages>
            {{-- Messages de statut --}}

            <div class="max-w-7xl mx-auto">
                <div class="flex justify-between items-center my-4 mx-1">
                    <h1 class="text-3xl font-bold py-4 pt-8">Modifier un Livre</h1>
                </div>

                {{-- Form --}}
                <form id="addBookForm" class="bg-white/5 dark:bg-black/5 rounded-xl p-6 shadow-lg space-y-4"
                    action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    {{-- title + author --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <x-label class="block text-sm font-medium mb-2" for="title">Titre</x-label>
                            <x-input-text type="text" id="title" name="title" required
                                value="{{ $book->title }}" />
                            @error('title')
                                <div>
                                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <x-label class="block text-sm font-medium mb-2" for="author">Auteur</x-label>
                            <x-input-text type="text" id="author" name="author" required
                                value="{{ $book->author }}" />
                            @error('author')
                                <div>
                                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>

                    {{-- resume --}}
                    <div class="form-group">
                        <x-label class="block text-sm font-medium mb-2" for="resume">Résumé</x-label>
                        <x-textarea id="summary" name="resume" rows="4" required>{{ $book->resume }}</x-textarea>
                        @error('resume')
                            <div>
                                <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- language --}}
                        <div class="form-group">
                            <x-label class="block text-sm font-medium mb-2" for="language">Langue</x-label>
                            <x-select id="language" name="language" required :selected="$book->language"
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
                        {{-- categories --}}
                        <div class="form-group relative" x-data="{
                            open: false,
                            selectedItems: {{ json_encode($book->categories->pluck('id')->toArray()) }},
                            categories: {{ json_encode($categories) }},
                            init() {
                                // Initialize with existing categories if editing
                                @if (isset($book) && $book->categories) this.selectedItems = {{ json_encode($book->categories->pluck('id')->toArray()) }}; @endif
                            },
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

                            <div @click="open = !open"
                                class="cursor-pointer w-full px-4 py-2 rounded-lg border border-light-primary/20 dark:border-dark-primary/20 bg-white/5 dark:bg-black/5 focus:ring-2 focus:ring-light-accent dark:focus:ring-dark-accent focus:outline-none focus:border-b-0 transition-all duration-300 flex justify-between items-center">
                                <template x-if="selectedItems.length === 0">
                                    <span class="text-gray-400">Sélectionnez des catégories...</span>
                                </template>
                                <div x-show="selectedItems.length > 0" class="flex flex-wrap gap-1">
                                    <template x-for="id in selectedItems" :key="id">
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-xs bg-blue-100 dark:bg-light-accent/10 text-light-accent/80 dark:text-light-accent/80 rounded-full">
                                            <span x-text="categories[id]"></span>
                                            <button @click.stop="toggleSelection(id, categories[id])"
                                                class="ml-1 text-blue-600 dark:text-blue-300 hover:text-blue-800">×</button>
                                        </span>
                                    </template>
                                </div>
                                <svg class="w-3 h-3 font-bold text-gray-400 transition-transform duration-200"
                                    :class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>

                            <div x-show="open" @click.outside="open = false" x-transition
                                class="absolute z-10 mt-1 w-full max-h-60 overflow-auto rounded-md bg-white dark:bg-dark-bg shadow-lg border border-light-accent dark:border-dark-accent">
                                <template x-for="(name, id) in categories" :key="id">
                                    <div @click="toggleSelection(id, name)"
                                        class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-dark-bg cursor-pointer flex items-center"
                                        :class="{ 'bg-gray-100 dark:bg-dark-bg': selectedItems.includes(id) }">
                                        <input type="checkbox" :checked="selectedItems.includes(id)"
                                            class="mr-2 rounded text-blue-600 focus:ring-blue-500">
                                        <span x-text="name"></span>
                                    </div>
                                </template>
                            </div>

                            <template x-for="id in selectedItems" :key="id">
                                <input type="hidden" name="categories[]" :value="id">
                            </template>

                            @error('categories')
                                <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- photo --}}
                    <div class="form-group" x-data="{
                        previewUrl: '{{ $book->photo ? asset('storage/' . $book->photo) : asset('images/default-book-cover.jpg') }}',
                        showPreview: true,
                        isHovering: false,
                        hasChanged: false,
                        init() {
                            this.showPreview = this.previewUrl !== '{{ asset('images/default-book-cover.jpg') }}';

                            const fileInput = this.$refs.coverUpload;
                            fileInput.addEventListener('change', (event) => {
                                const file = event.target.files[0];
                                if (file) {
                                    // Vérification du type de fichier
                                    const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
                                    if (!validTypes.includes(file.type)) {
                                        alert('Format de fichier non supporté. Veuillez choisir une image JPEG, PNG ou WEBP.');
                                        return;
                                    }

                                    // Vérification de la taille du fichier (max 5MB)
                                    if (file.size > 5 * 1024 * 1024) {
                                        alert('La taille de l\'image ne doit pas dépasser 5MB.');
                                        return;
                                    }

                                    this.previewUrl = URL.createObjectURL(file);
                                    this.showPreview = true;
                                    this.hasChanged = true;
                                }
                            });
                        }
                    }">
                        <x-label class="block text-sm font-medium mb-3 text-light-text dark:text-dark-text">
                            Photo de couverture
                        </x-label>

                        <div class="flex flex-col sm:flex-row gap-6 items-start">
                            {{-- Card --}}
                            <div x-show="showPreview" @mouseenter="isHovering = true" @mouseleave="isHovering = false"
                                class="relative w-full sm:w-28 h-36 rounded-xl overflow-hidden shadow-md border-2 border-light-primary/20 dark:border-dark-primary/20 transition-all duration-300"
                                :class="{ 'ring-2 ring-light-accent dark:ring-dark-accent': isHovering }">
                                <img :src="previewUrl" alt="Couverture actuelle du livre"
                                    class="w-full h-full object-cover transition-transform duration-500"
                                    :class="{ 'scale-105': isHovering }">

                                <div x-show="isHovering"
                                    class="absolute inset-0 bg-black/40 flex items-center justify-center transition-opacity duration-300">
                                    <span class="text-white text-sm font-medium">Cliquez pour changer</span>
                                </div>

                                <input type="file" x-ref="coverUpload" name="photo"
                                    accept="image/jpeg,image/png,image/webp"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            </div>

                            <div class="flex-1 space-y-4 min-w-[200px]">
                                <label x-ref="uploadLabel" class="block">
                                    <div
                                        class="px-4 py-2.5 bg-light-accent/90 dark:bg-dark-accent/90 hover:bg-light-accent dark:hover:bg-dark-accent text-white rounded-lg font-medium text-center cursor-pointer transition-colors duration-200">
                                        <i class="fas fa-cloud-upload-alt mr-2"></i> Choisir une nouvelle image
                                    </div>
                                    <input type="file" x-ref="coverUpload" name="photo"
                                        accept="image/jpeg,image/png,image/webp" class="hidden">
                                </label>


                                <div
                                    class="p-3 bg-light-primary/5 dark:bg-dark-primary/5 rounded-lg border border-dashed border-light-primary/20 dark:border-dark-primary/20">
                                    <p class="text-xs text-light-text/70 dark:text-dark-text/70 mb-1">
                                        <i class="fas fa-info-circle mr-1"></i> Formats supportés: JPEG, PNG, WEBP (max
                                        5MB)
                                    </p>
                                    <p class="text-xs text-light-text/70 dark:text-dark-text/70">
                                        <i class="fas fa-expand-alt mr-1"></i> Taille recommandée: 600×900 pixels
                                    </p>
                                </div>

                                <input type="hidden" name="photo_changed" x-model="hasChanged">

                                <template
                                    x-if="!hasChanged && previewUrl !== '{{ asset('images/default-book-cover.jpg') }}'">
                                    <input type="hidden" name="photo" value="{{ $book->photo }}">
                                </template>
                            </div>
                        </div>

                        @error('photo')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-start">
                                <i class="fas fa-exclamation-circle mt-0.5 mr-1.5"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- date_edition --}}
                        <div class="form-group">
                            <x-label class="block text-sm font-medium mb-2" for="publishDate">Date d'édition</x-label>
                            <x-input-text type="date" id="publishDate" name="date_edition" required
                                value="{{ $book->date_edition }}" />
                            @error('date_edition')
                                <div>
                                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                        {{-- isbn --}}
                        <div class="form-group">
                            <x-label class="block text-sm font-medium mb-2" for="isbn">ISBN</x-label>
                            <x-input-text type="text" id="isbn" name="isbn" required
                                value="{{ $book->isbn }}" />
                            @error('isbn')
                                <div>
                                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>



                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- nbr_pages --}}
                        <div class="form-group">
                            <x-label class="block text-sm font-medium mb-2" for="pages">Nombre de pages</x-label>
                            <x-input-text type="number" id="pages" name="nbr_pages" required min="1"
                                value="{{ $book->nbr_pages }}" />
                            @error('nbr_pages')
                                <div>
                                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                        {{-- prix_emprunt --}}
                        <div class="form-group">
                            <x-label class="block text-sm font-medium mb-2" for="borrowPrice">Prix d'emprunt (€)</x-label>
                            <x-input-text type="number" id="borrowPrice" name="prix_emprunte" required min="0"
                                value="{{ $book->prix_emprunte }}" step="0.01" />
                            @error('prix_emprunte')
                                <div>
                                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>

                    {{-- Button --}}
                    <div class="flex justify-end space-x-4">
                        <x-secondary-button type="button" onclick="window.history.back()">
                            Annuler
                        </x-secondary-button>
                        <x-primary-button type="submit">
                            Modifier le livre
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </main>
    </div>
@endsection
