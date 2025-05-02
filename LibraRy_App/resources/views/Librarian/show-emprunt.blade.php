@extends('layouts.admin-layout')

@section('title', 'Détails de l\'emprunt')
@section('header', 'Détails de l\'emprunt')

@section('content')
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-light-bg dark:bg-dark-bg md:p-10 p-2 gap-6">
        {{-- Messages de statut --}}
        <x-messages></x-messages>
        {{-- Messages de statut --}}
        <div class="max-w-6xl">
            <div class="bg-white dark:bg-dark-primary/10 rounded-xl shadow-md overflow-hidden">
                <div class="p-6 border-b border-light-primary/10 dark:border-dark-primary/10">
                    <div class="flex justify-between items-center">
                        <h1 class="text-2xl font-bold text-light-text dark:text-dark-text">Détails de l'emprunt</h1>
                        <a href="{{ route('librarian.emprunts.index') }}"
                            class="text-light-primary dark:text-dark-primary hover:underline">
                            ← Retour à la liste
                        </a>
                    </div>
                </div>

                <div class="p-6">
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-6">
                            {{-- Section Livre --}}
                            <div class="bg-light-primary/5 hover:shadow-xl dark:bg-dark-primary/5 p-6 rounded-lg shadow-sm">
                                <h2
                                    class="text-xl font-semibold mb-4 pb-2 border-b border-light-primary/10 dark:border-dark-primary/10">
                                    <i class="fas fa-book mr-2"></i>Informations du livre
                                </h2>
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-sm text-light-text/50 dark:text-dark-text/50 mb-1">Titre</p>
                                        <p class="font-medium">{{ $emprunt->exemplaire->book->title }}</p>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2  gap-4">
                                        <div>
                                            <p class="text-sm text-light-text/50 dark:text-dark-text/50 mb-1">Auteur</p>
                                            <p class="font-medium">{{ $emprunt->exemplaire->book->author }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-light-text/50 dark:text-dark-text/50 mb-1">ISBN</p>
                                            <p class="font-medium">{{ $emprunt->exemplaire->book->isbn }}</p>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm text-light-text/50 dark:text-dark-text/50 mb-1">Code exemplaire
                                        </p>
                                        <p class="font-medium text-light-primary dark:text-dark-primary">
                                            {{ $emprunt->exemplaire->code_serial_exemplaire }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Section Utilisateur --}}
                            <div class="bg-light-primary/5 hover:shadow-xl dark:bg-dark-primary/5 p-6 rounded-lg shadow-sm">
                                <h2
                                    class="text-xl font-semibold mb-4 pb-2 border-b border-light-primary/10 dark:border-dark-primary/10">
                                    <i class="fas fa-user mr-2"></i>Informations de l'emprunteur
                                </h2>
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-sm text-light-text/50 dark:text-dark-text/50 mb-1">Nom complet</p>
                                        <p class="font-medium">{{ $emprunt->user->first_name }}
                                            {{ $emprunt->user->last_name }}</p>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-sm text-light-text/50 dark:text-dark-text/50 mb-1">Email</p>
                                            <p class="font-medium">{{ $emprunt->user->email }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-light-text/50 dark:text-dark-text/50 mb-1">Téléphone</p>
                                            <p class="font-medium">{{ $emprunt->user->telephone ?? 'Non renseigné' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Détails de l'emprunt --}}
                        <div class="bg-light-primary/5 hover:shadow-xl dark:bg-dark-primary/5 p-6 rounded-lg shadow-sm">
                            <h2
                                class="text-xl font-semibold mb-4 pb-2 border-b border-light-primary/10 dark:border-dark-primary/10">
                                <i class="fas fa-calendar-alt mr-2"></i>Détails de l'emprunt
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <p class="text-sm text-light-text/50 dark:text-dark-text/50 mb-1">Date d'emprunt</p>
                                    <p class="font-medium">
                                        {{ Carbon\Carbon::parse($emprunt->date_emprunt)->translatedFormat('d F Y') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-light-text/50 dark:text-dark-text/50 mb-1">Retour prévu</p>
                                    <p class="font-medium">
                                        {{ Carbon\Carbon::parse($emprunt->date_retour_prevue)->translatedFormat('d F Y') }}
                                    </p>
                                </div>
                                @if ($emprunt->date_retour_effectif !== null)
                                    <div>
                                        <p class="text-sm text-light-text/50 dark:text-dark-text/50 mb-1">Retour prévu</p>
                                        <p class="font-medium">
                                            {{ Carbon\Carbon::parse($emprunt->date_retour_prevue)->translatedFormat('d F Y') }}
                                        </p>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm text-light-text/50 dark:text-dark-text/50 mb-1">Statut</p>
                                    <p class="font-medium">
                                        @if ($emprunt->status === 'validé')
                                            <span
                                                class="px-3 py-1 rounded-full text-sm bg-green-100 text-green-800 dark:bg-green-900 dark:bg-opacity-20 dark:text-green-200">
                                                Validé
                                            </span>
                                        @elseif($emprunt->status === 'retard')
                                            <span
                                                class="px-3 py-1 rounded-full text-sm bg-red-100 text-red-800 dark:bg-red-900 dark:bg-opacity-20 dark:text-red-200">
                                                En retard
                                            </span>
                                        @elseif($emprunt->status === 'en attente')
                                            <span
                                                class="px-3 py-1 rounded-full text-sm bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:bg-opacity-20 dark:text-yellow-200">
                                                En attente
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="mt-8 pt-6 border-t border-light-primary/10 dark:border-dark-primary/10 grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 justify-end gap-4">
                        <a href="{{ route('librarian.emprunts.index') }}">
                            <x-secondary-button class="px-4"><i class="fas fa-arrow-left mr-2"></i> Retour à la
                                liste</x-secondary-button>
                        </a>

                        @if ($emprunt->status === 'en attente')
                            <form action="{{ route('librarian.emprunts.valider', $emprunt->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <x-primary-button type="submit">
                                    <i class="fas fa-check mr-2"></i> Valider l'emprunt
                                </x-primary-button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
