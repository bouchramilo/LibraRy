@extends('layouts.admin-layout')

@section('title', 'Tableau de bord')
@section('header', 'Tableau de bord')

@section('content')
    <!-- Main Content -->
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-light-bg dark:bg-dark-bg p-4 md:p-6 lg:p-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 xl:gap-12">
            <!-- Image Section -->
            <div class="flex justify-center items-start">
                <img
                    src="{{ $exemplaire->book->photo ? asset('storage/' . $exemplaire->book->photo) : asset('images/default-avatar.jpg') }}"
                    alt="Couverture du livre"
                    class="max-h-[500px] w-auto rounded-lg shadow-lg object-contain hover:scale-105 hover:shadow-2xl hover:shadow-light-secondary"
                >
            </div>

            <!-- Details Section -->
            <div class="space-y-6">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold font-playfair">{{ $exemplaire->book->title }}</h1>

                <div class="space-y-4">
                    <div class="flex flex-wrap items-start">
                        <span class="w-32 font-semibold">Auteur:</span>
                        <span class="flex-1">{{ $exemplaire->book->author }}</span>
                    </div>
                    <div class="flex flex-wrap items-start">
                        <span class="w-32 font-semibold">Date d'édition:</span>
                        <span class="flex-1">{{ $exemplaire->book->date_edition }}</span>
                    </div>
                    <div class="flex flex-wrap items-start">
                        <span class="w-32 font-semibold">Pages:</span>
                        <span class="flex-1">{{ $exemplaire->book->nbr_pages }}</span>
                    </div>
                    <div class="flex flex-wrap items-start">
                        <span class="w-32 font-semibold">Genre:</span>
                        <div class="flex-1 flex flex-wrap gap-2">
                            @foreach ($exemplaire->book->categories as $cate)
                                <span class="bg-accent/10 text-accent rounded-full px-3 py-1 text-sm">
                                    {{ $cate->category }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex flex-wrap items-start">
                        <span class="w-32 font-semibold">Langue:</span>
                        <span class="flex-1">{{ $exemplaire->book->language }}</span>
                    </div>
                    <div class="flex flex-wrap items-start">
                        <span class="w-32 font-semibold">ISBN:</span>
                        <span class="flex-1">{{ $exemplaire->book->isbn }}</span>
                    </div>
                    <div class="flex flex-wrap items-start">
                        <span class="w-32 font-semibold">Etat:</span>
                        <span class="flex-1">{{ $exemplaire->etat }}</span>
                    </div>
                    <div class="flex flex-wrap items-start">
                        <span class="w-32 font-semibold">code serial d'exemplaire:</span>
                        <span class="flex-1">{{ $exemplaire->code_serial_exemplaire }}</span>
                    </div>
                    <div class="flex flex-wrap items-start">
                        <span class="w-32 font-semibold">Emplacement:</span>
                        <span class="flex-1">{{ $exemplaire->rayon }} - {{ $exemplaire->etagere }}</span>
                    </div>
                </div>

                <!-- Pricing Section -->
                <div class="border-t border-b border-light-text/10 dark:border-dark-text/10 py-6 space-y-6">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div>
                            <p class="text-lg md:text-xl font-semibold">Prix d'achat: {{ $exemplaire->book->prix_vente }}€</p>
                            <p class="text-sm text-light-text/70 dark:text-dark-text/70">En stock</p>
                        </div>

                    </div>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div>
                            <p class="text-lg md:text-xl font-semibold">Prix d'emprunt: {{ $exemplaire->book->prix_emprunte }}€</p>
                            <p class="text-sm text-light-text/70 dark:text-dark-text/70">Disponible</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Section -->
        <div class="mt-8 md:mt-12 space-y-4">
            <h2 class="text-xl md:text-2xl font-bold">Résumé</h2>
            <p class="leading-relaxed text-justify">
                {{ $exemplaire->book->resume }}
            </p>
        </div>
    </main>
@endsection
