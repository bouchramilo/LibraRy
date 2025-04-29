@extends('layouts.client-layout')

@section('title', 'LibraRy - Mes Emprunts')
@section('header', 'LibraRy - Mes Emprunts')

@section('content')
    <main class="flex-grow container mx-auto px-4 py-8 pt-6 pb-16 sm:px-6 lg:px-8 max-w-7xl min-h-screen">
        <x-messages/>
        <div class="mb-8">
            <h1 class="text-3xl font-heading font-bold mb-6">Mes Emprunts en Cours</h1>
            <form method="GET" action="{{ route('client.emprunt.show') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {{-- Champ de recherche --}}
                    <div class="relative flex-grow">
                        <x-input-text name="search" type="text" placeholder="Rechercher un livre..." class="pl-10"
                            value="{{ request('search') }}" />
                        <i
                            class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-light-text/50 dark:text-dark-text/50"></i>
                    </div>

                    {{-- Sélecteur de livre --}}
                    <x-select id="status" name="status" placeholder="Status" :options="['validé' => 'validé', 'retard' => 'retard', 'en attente' => 'en attente']" :selected="request('status')" />

                    {{-- Boutons --}}
                    <div class="flex justify-end gap-2">
                        @if (request('search') || request('status'))
                            <a href="{{ route('client.emprunt.show') }}"
                                class="px-6 py-2 rounded-lg bg-light-primary/10 dark:bg-dark-primary/10 hover:bg-light-primary/20 dark:hover:bg-dark-primary/20 transition-colors">
                                Réinitialiser
                            </a>
                        @endif
                        <x-primary-button type="submit" class="w-full">
                            Appliquer
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>

        @if ($mesEmprunts->isEmpty())
            <div class="bg-white dark:bg-dark-primary/10 rounded-lg p-8 text-center">
                <p class="text-lg">Vous n'avez aucun emprunt en cours</p>
                <a href="{{ route('client.catalogue') }}"
                    class="text-light-accent dark:text-dark-accent hover:underline mt-4 inline-block">
                    Parcourir le catalogue
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                @foreach ($mesEmprunts as $emprunt)
                    <div
                        class="bg-white dark:bg-dark-primary/10 border border-light-text/10 dark:border-dark-text/10 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col sm:flex-row">
                        <div class="w-full sm:w-32 md:w-40 lg:w-48 h-48 sm:h-auto">
                            <a href="{{ route('client.catalogue.show', $emprunt->exemplaire->id) }}"><img
                                    src="{{ $emprunt->exemplaire->book->photo ? asset('storage/' . $emprunt->exemplaire->book->photo) : asset('images/default-avatar.jpg') }}"
                                    alt="{{ $emprunt->exemplaire->book->title }} by {{ $emprunt->exemplaire->book->author }}"
                                    class="w-full h-full object-cover rounded-lg"></a>
                        </div>

                        <div class="p-4 flex-1 flex flex-col">
                            <h3 class="font-bold text-xl mb-2 line-clamp-2">{{ $emprunt->exemplaire->book->title }}</h3>
                            <p class="text-light-text/70 dark:text-dark-text/70 mb-1">
                                {{ $emprunt->exemplaire->book->author }}</p>
                            <p class="text-light-text/70 dark:text-dark-text/70 mb-1 text-sm">Code:
                                {{ $emprunt->exemplaire->code_serial_exemplaire }}</p>
                                <p class="text-light-text/70 dark:text-dark-text/70 mb-1 text-sm">Date d'emprunt :
                                    {{ Carbon\Carbon::parse($emprunt->date_emprunt)->translatedFormat('d M Y') }}</p>
                                <p class="text-light-text/70 dark:text-dark-text/70 mb-1 text-sm">Date de retour prévue :
                                    {{ Carbon\Carbon::parse($emprunt->date_retour_prevue)->translatedFormat('d M Y') }}</p>

                            <div class="mb-4 mt-2">
                                <span
                                    class="inline-block px-2 py-1 text-xs font-semibold rounded-full
                                    @if ($emprunt->status === 'validé') bg-green-100 text-green-800
                                    @elseif($emprunt->status === 'retard') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ $emprunt->status }}
                                </span>
                            </div>

                            <div class="mt-auto flex flex-row items-end justify-end gap-2 w-full">
                                @if ($emprunt->status === 'en attente')
                                    <form action="{{ route('client.emprunt.annuler', $emprunt->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <x-primary-button>Annuler</x-primary-button>
                                    </form>
                                @elseif($emprunt->status === 'validé' || $emprunt->status === 'retard')
                                    <form action="" method="POST">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="emprunt_id" value="{{ $emprunt->id }}">
                                        <x-primary-button>Retourner</x-primary-button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>
@endsection
