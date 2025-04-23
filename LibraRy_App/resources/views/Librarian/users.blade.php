@extends('layouts.admin-layout')

@section('title', 'Gestion des utilisateurs')
@section('header', 'LibraRy - Utilisateurs')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <!-- Content Header -->
        <div class="flex justify-between items-center mb-8 fade-in">
            <h1 class="text-3xl font-bold">Gestion des Utilisateurs</h1>
        </div>

        <!-- Filters -->
        <div class="mb-8 grid md:grid-cols-4 gap-4 fade-in">
            <!-- Champ Recherche -->
            <div class="relative">
                <input type="text"
                       id="searchInput"
                       placeholder="Rechercher..."
                       class="w-full px-4 py-2 rounded-lg border border-gray-300">
            </div>

            <!-- Select Rôle -->
            <select id="roleFilter" class="px-4 py-2 rounded-lg border border-gray-300">
                <option value="">Tous les rôles</option>
                <option value="Client">Client</option>
                <option value="Bibliothécaire">Bibliothécaire</option>
            </select>

            <!-- Select Statut -->
            <select id="statusFilter" class="px-4 py-2 rounded-lg border border-gray-300">
                <option value="">Tous les statuts</option>
                <option value="Active">Actif</option>
                <option value="Suspendu">Suspendu</option>
            </select>

            <!-- Bouton Appliquer -->
            <button id="applyFiltersBtn"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Appliquer
            </button>
        </div>
        <!-- Users Table -->
        <div class="bg-white/5 dark:bg-black/5 rounded-xl shadow-lg overflow-hidden fade-in">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-light-primary/10 dark:border-dark-primary/10">
                        <th class="px-6 py-3 text-left">Nom</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Rôle</th>
                        <th class="px-6 py-3 text-left">Statut</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody">
                    @foreach ($users as $client)
                        <tr class="animate-fade-up theme-transition hover:bg-light-primary/5 dark:hover:bg-dark-primary/5">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    {{-- <img src="{{ $client->photo ? asset('storage/' . $client->photo) : asset('images/default-avatar.jpg') }}"
                                        alt="{{ $client->first_name }} {{ $client->last_name }}" class="w-10 h-10 rounded-full"> --}}
                                    <span>{{ $client->first_name }} {{ $client->last_name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $client->email }}</td>
                            <td class="px-6 py-4">{{ $client->role }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 rounded-full text-sm {{ $client->status === 'Active' ? 'bg-green-500/10 text-green-500' : 'bg-orange-500/10 text-orange-500' }}">
                                    {{ $client->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end space-x-2">
                                    <button onclick="showUserDetails({{ $client->id }})"
                                        class="p-2 rounded-lg hover:bg-light-primary/10 dark:hover:bg-dark-primary/10 tooltip"
                                        title="Voir les détails">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>
                                    <form action="{{ route('manage.users.status') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" value="{{ $client->id }}" name="user_id"
                                            class="p-2 rounded-lg hover:bg-light-primary/10 dark:hover:bg-dark-primary/10 text-yellow-500"
                                            title="Suspendre">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('manage.users.delete', $client->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="p-2 rounded-lg hover:bg-light-primary/10 dark:hover:bg-dark-primary/10 text-red-500"
                                            title="Supprimer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-between items-center w-full">
            {{ $users->links('vendor.pagination.default') }}
        </div>
    </div>

    <!-- Modal -->
    <div x-data="{ showModal: false, selectedUser: null }" x-show="showModal" class="fixed inset-0 bg-black/50 flex items-center justify-center">
        <!-- ... contenu du modal ... -->
    </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const applyBtn = document.getElementById('applyFiltersBtn');

    applyBtn.addEventListener('click', function() {
        // Récupérer les valeurs
        const search = document.getElementById('searchInput').value;
        const role = document.getElementById('roleFilter').value;
        const status = document.getElementById('statusFilter').value;

        // Construire l'URL
        let url = '/admin/users?';
        if (search) url += `search=${encodeURIComponent(search)}&`;
        if (role) url += `role=${encodeURIComponent(role)}&`;
        if (status) url += `status=${encodeURIComponent(status)}`;

        // Recharger la page avec les paramètres
        window.location.href = url.replace(/&$/, '');
    });
});
</script>
@endsection
