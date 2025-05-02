@extends('layouts.admin-layout')

@section('title', 'Gestion des Emprunts')
@section('header', 'Gestion des Emprunts')

@section('content')

    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-light-bg dark:bg-dark-bg md:p-10 p-2 gap-6">
        {{-- messages start --}}
        <x-messages />
        {{-- messages end --}}
        <div class="max-w-7xl mx-auto text-light-text dark:text-dark-text">
            {{-- Filtres --}}
            <div class="flex flex-col md:flex-col lg:flex-col justify-between items-start mb-8  md:p-10 p-2 gap-4">
                <h1 class="text-3xl font-bold">Gestion des Emprunts</h1>

                <form method="GET" action="{{ route('librarian.emprunts.index') }}"
                    class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-3 gap-4 w-full md:w-full">
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

            {{--  Statistiques --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-light-primary/10 dark:bg-dark-primary/10 p-6 rounded-xl">
                    <h3 class="text-xl font-bold mb-2">Emprunts Actifs</h3>
                    <p class="text-3xl font-bold text-light-primary dark:text-dark-primary">{{ $stats['en_attente'] }}</p>
                </div>
                <div class="bg-light-primary/10 dark:bg-dark-primary/10 p-6 rounded-xl">
                    <h3 class="text-xl font-bold mb-2">En Cours</h3>
                    <p class="text-3xl font-bold text-green-500">{{ $stats['en_cours'] }}</p>
                </div>
                <div class="bg-light-primary/10 dark:bg-dark-primary/10 p-6 rounded-xl">
                    <h3 class="text-xl font-bold mb-2">En Retard</h3>
                    <p class="text-3xl font-bold text-red-500">{{ $stats['retard_exemplaire'] }}</p>
                </div>
            </div>

            {{--  Tableau des Emprunts --}}
            <div class="bg-white dark:bg-dark-primary/10 rounded-xl shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
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
                                    <td class="px-2 py-4 flex justify-center">
                                        @if ($emprunt->status === 'validé')
                                            <span
                                                class="px-1 py-1 rounded-full text-xs bg-green-100 text-green-800 ">Validé</span>
                                        @elseif($emprunt->status === 'retard')
                                            <span class="px-1 py-1 rounded-full text-xs bg-red-100 text-red-800">En
                                                retard</span>
                                        @else
                                            <span class="px-1 py-1 rounded-full text-xs bg-yellow-100 text-yellow-800 ">En
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
@endsection
