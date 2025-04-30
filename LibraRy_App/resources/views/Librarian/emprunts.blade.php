@extends('layouts.admin-layout')

@section('title', 'Gestion des Emprunts')
@section('header', 'Gestion des Emprunts')

@section('content')

    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-light-bg dark:bg-dark-bg p-6 gap-6">
        {{-- messages start --}}
        <x-messages />
        {{-- messages end --}}
        <div class="max-w-7xl mx-auto text-light-text dark:text-dark-text">
            <!-- Header et Filtres -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <h1 class="text-3xl font-bold">Gestion des Emprunts</h1>

                <form method="GET" action="{{ route('librarian.emprunts.index') }}"
                    class="flex flex-col md:flex-row gap-4 w-full md:w-2/3">
                    <div class="relative flex-grow">
                        <x-input-text name="search" type="text" placeholder="Rechercher..." class="pl-10"
                            value="{{ request('search') }}" />
                        <i
                            class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-light-text/50 dark:text-dark-text/50"></i>
                    </div>

                    <x-select name="status" :options="$statusOptions" :selected="request('status')" placeholder="Tous les statuts" />

                    <div class="flex gap-2">
                        @if (request('search') || request('status'))
                            <a href="{{ route('librarian.emprunts.index') }}"
                                class="px-4 py-2 rounded-lg bg-light-primary/10 dark:bg-dark-primary/10 hover:bg-light-primary/20 transition-colors">
                                Réinitialiser
                            </a>
                        @endif
                        <x-primary-button type="submit">
                            Filtrer
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-light-primary/10 dark:bg-dark-primary/10 p-6 rounded-xl">
                    <h3 class="text-xl font-bold mb-2">Emprunts Actifs</h3>
                    <p class="text-3xl font-bold text-light-primary dark:text-dark-primary">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-light-primary/10 dark:bg-dark-primary/10 p-6 rounded-xl">
                    <h3 class="text-xl font-bold mb-2">En Cours</h3>
                    <p class="text-3xl font-bold text-green-500">{{ $stats['en_cours'] }}</p>
                </div>
                <div class="bg-light-primary/10 dark:bg-dark-primary/10 p-6 rounded-xl">
                    <h3 class="text-xl font-bold mb-2">En Retard</h3>
                    <p class="text-3xl font-bold text-red-500">{{ $stats['en_retard'] }}</p>
                </div>
            </div>

            <!-- Tableau des Emprunts -->
            <div class="bg-white dark:bg-dark-primary/10 rounded-xl shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-light-primary/5 dark:bg-dark-primary/5">
                            <tr>
                                <th class="px-6 py-3 text-left">Livre</th>
                                <th class="px-6 py-3 text-left">Utilisateur</th>
                                <th class="px-6 py-3 text-left">Code</th>
                                <th class="px-6 py-3 text-left">Emprunt</th>
                                <th class="px-6 py-3 text-left">Retour Prévu</th>
                                <th class="px-6 py-3 text-left">Statut</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($emprunts as $emprunt)
                                <tr
                                    class="border-t border-light-primary/10 dark:border-dark-primary/10 hover:bg-light-primary/5 transition-colors">
                                    <td class="px-6 py-4">{{ $emprunt->exemplaire->book->title }}</td>
                                    <td class="px-6 py-4">{{ $emprunt->user->first_name }} {{ $emprunt->user->last_name }}
                                    </td>
                                    <td class="px-6 py-4">{{ $emprunt->exemplaire->code_serial_exemplaire }}</td>
                                    <td class="px-6 py-4">
                                        {{ Carbon\Carbon::parse($emprunt->date_emprunt)->translatedFormat('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        {{ Carbon\Carbon::parse($emprunt->date_retour_prevue)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($emprunt->status === 'validé')
                                            <span
                                                class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Validé</span>
                                        @elseif($emprunt->status === 'retard')
                                            <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-800">En
                                                retard</span>
                                        @else
                                            <span class="px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-800">En
                                                cours</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('librarian.emprunts.details', $emprunt->id) }}"><button
                                                    class="p-2 text-gray-600 hover:text-gray-900 dark:hover:text-white">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </button>
                                            </a>
                                            @if ($emprunt->status === 'en attente')
                                                <form action="{{ route('librarian.emprunts.valider', $emprunt->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="p-2 text-green-600 hover:text-green-800">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                            @if ($emprunt->status === 'validé' || $emprunt->status === 'retard')
                                                <form action="{{ route('librarian.emprunt.retourner', $emprunt->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="p-2 text-green-600 hover:text-green-800">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center">Aucun emprunt trouvé</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($emprunts->hasPages())
                    <div class="px-6 py-4 border-t border-light-primary/10">
                        {{ $emprunts->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Modal Détails -->
    {{-- <div x-data="{
        show: false,
        emprunt: null,
        loading: false,
        async showDetail(id) {
            this.loading = true;
            this.show = true;
            try {
                const response = await fetch(`/librarian/emprunts/${id}/details`);
                if (!response.ok) throw new Error('Erreur lors du chargement');
                this.emprunt = await response.json();
            } catch (error) {
                console.error(error);
                // Gérer l'erreur ici (peut-être afficher un message à l'utilisateur)
            } finally {
                this.loading = false;
            }
        }
    }" x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50">
        <div @click.away="show = false" class="w-full max-w-2xl bg-white dark:bg-dark-bg rounded-xl shadow-lg overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-2xl font-bold">Détails de l'emprunt</h3>
                    <button @click="show = false" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <template x-if="loading">
                    <div class="flex justify-center py-8">
                        <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-primary"></div>
                    </div>
                </template>

                <template x-if="!loading && emprunt">
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Section Livre -->
                            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                                <h4 class="font-semibold text-lg mb-3 border-b pb-2">Informations du livre</h4>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Titre</p>
                                        <p x-text="emprunt.exemplaire.book.title" class="font-medium"></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Auteur</p>
                                        <p x-text="emprunt.exemplaire.book.author" class="font-medium"></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Code exemplaire</p>
                                        <p x-text="emprunt.exemplaire.code_serial_exemplaire" class="font-medium"></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">ISBN</p>
                                        <p x-text="emprunt.exemplaire.book.isbn" class="font-medium"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Section Utilisateur -->
                            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                                <h4 class="font-semibold text-lg mb-3 border-b pb-2">Informations de l'emprunteur</h4>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Nom complet</p>
                                        <p x-text="emprunt.user.name" class="font-medium"></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                                        <p x-text="emprunt.user.email" class="font-medium"></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Téléphone</p>
                                        <p x-text="emprunt.user.phone || 'Non renseigné'" class="font-medium"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section Emprunt -->
                        <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                            <h4 class="font-semibold text-lg mb-3 border-b pb-2">Détails de l'emprunt</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Date d'emprunt</p>
                                    <p x-text="new Date(emprunt.date_emprunt).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' })" class="font-medium"></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Date de retour prévue</p>
                                    <p x-text="new Date(emprunt.date_retour_prevue).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' })" class="font-medium"></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Statut</p>
                                    <p class="font-medium">
                                        <template x-if="emprunt.status === 'validé'">
                                            <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Validé</span>
                                        </template>
                                        <template x-if="emprunt.status === 'retard'">
                                            <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-800">En retard</span>
                                        </template>
                                        <template x-if="emprunt.status === 'en cours'">
                                            <span class="px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-800">En cours</span>
                                        </template>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Section Actions -->
                        <div class="flex justify-end gap-3 pt-4 border-t">
                            <button @click="show = false" class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                Fermer
                            </button>
                            <template x-if="emprunt.status === 'en attente'">
                                <button class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 transition-colors">
                                    Valider l'emprunt
                                </button>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div> --}}
@endsection
