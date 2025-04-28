@extends('layouts.admin-layout')

@section('title', 'Gestion des Emprunts')
@section('header', 'Gestion des Emprunts')

@section('content')
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-light-bg dark:bg-dark-bg p-6 gap-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header et Filtres -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <h1 class="text-3xl font-bold">Gestion des Emprunts</h1>

                <form  method="GET" action="{{ route('librarian.emprunts.index') }}"
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
                                    <td class="px-6 py-4">{{ $emprunt->user->name }}</td>
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
                                            <button @click="showDetail({{ $emprunt->id }})"
                                                class="p-2 text-gray-600 hover:text-gray-900 dark:hover:text-white">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                            @if ($emprunt->status === 'en attente')
                                                <form action="{{ route('librarian.emprunts.valider', $emprunt->id) }}" method="POST">
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
    <div x-data="{
        show: false,
        emprunt: null,
        async showDetail(id) {
            const response = await fetch(`/api/emprunts/${id}`);
            this.emprunt = await response.json();
            this.show = true;
        }
    }" x-show="show" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50">
        <div class="w-full max-w-md bg-white dark:bg-dark-bg rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold mb-4">Détails de l'emprunt</h3>
            <template x-if="emprunt">
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Livre</p>
                        <p x-text="emprunt.book_title" class="font-medium"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Utilisateur</p>
                        <p x-text="emprunt.user_name" class="font-medium"></p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Date emprunt</p>
                            <p x-text="new Date(emprunt.date_emprunt).toLocaleDateString()" class="font-medium"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Date retour</p>
                            <p x-text="new Date(emprunt.date_retour_prevue).toLocaleDateString()" class="font-medium"></p>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Statut</p>
                        <p x-text="emprunt.status" class="font-medium"></p>
                    </div>
                </div>
            </template>
            <div class="mt-6 flex justify-end">
                <button @click="show = false"
                    class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 dark:bg-dark-primary/10 dark:hover:bg-dark-primary/20 transition-colors">
                    Fermer
                </button>
            </div>
        </div>
    </div>
@endsection
