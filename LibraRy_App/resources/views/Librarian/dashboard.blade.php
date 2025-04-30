@extends('layouts.admin-layout')

@section('title', 'Tableau de bord')
@section('header', 'Tableau de bord')

@section('content')
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-light-bg dark:bg-dark-bg p-6">


        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-center my-8 gap-4">
                <h1 class="text-3xl font-bold w-full">Tableau de Bord</h1>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- users -->
                <div class="stat-card bg-light-primary/10 dark:bg-dark-primary/10 p-6 rounded-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-2">Total des Clients</h3>
                            <p class="text-3xl font-bold text-blue-500" id="salesAmount">{{ $total_users }}</p>
                        </div>
                        <div class="p-4 bg-blue-500/20 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Total Books -->
                <div class="stat-card bg-light-primary/10 dark:bg-dark-primary/10 p-6 rounded-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-2">Total des Livres</h3>
                            <p class="text-3xl font-bold text-light-primary dark:text-dark-primary" id="totalBooks">
                                {{ $nbr_books }}
                            </p>
                        </div>
                        <div class="p-4 bg-light-primary/20 dark:bg-dark-primary/20 rounded-lg">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Total exemplaires -->
                <div class="stat-card bg-light-primary/10 dark:bg-dark-primary/10 p-6 rounded-xl">
                    <div class="flex items-center justify-between">

                        <div>
                            <h3 class="text-xl font-bold mb-2">Total des exemplaires</h3>
                            <p class="text-3xl font-bold text-light-primary dark:text-dark-primary" id="totalBooks">
                                {{ $nbr_exemplaires }}
                            </p>
                        </div>
                        <div class="p-4 bg-light-primary/20 dark:bg-dark-primary/20 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 6v12a1 1 0 001 1h14M21 6v12a1 1 0 01-1 1H7M3 6a1 1 0 011-1h14a1 1 0 011 1" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Borrowed Books -->
                <div class="stat-card bg-light-primary/10 dark:bg-dark-primary/10 p-6 rounded-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-2">Livres Empruntés</h3>
                            <p class="text-3xl font-bold text-light-accent dark:text-dark-accent" id="borrowedBooks">
                                {{ $exmp_non_dispo }}</p>
                        </div>
                        <div class="p-4 bg-light-accent/20 dark:bg-dark-accent/20 rounded-lg">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Pending Borrows -->
                <div class="stat-card bg-light-primary/10 dark:bg-dark-primary/10 p-6 rounded-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-2">En Attente d'Emprunt</h3>
                            <p class="text-3xl font-bold text-yellow-500" id="pendingBorrows">{{ $pending_borrows }}</p>
                        </div>
                        <div class="p-4 bg-yellow-500/20 rounded-lg">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Pending Sales -->
                <div class="stat-card bg-light-primary/10 dark:bg-dark-primary/10 p-6 rounded-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-2">En Attente d'Achat</h3>
                            <p class="text-3xl font-bold text-orange-500" id="pendingSales">18</p>
                        </div>
                        <div class="p-4 bg-orange-500/20 rounded-lg">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Borrows Amount -->
                <div class="stat-card bg-light-primary/10 dark:bg-dark-primary/10 p-6 rounded-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-2">Montant Emprunts</h3>
                            <p class="text-3xl font-bold text-green-500" id="borrowsAmount">3,250 €</p>
                        </div>
                        <div class="p-4 bg-green-500/20 rounded-lg">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 ">
                <div class="bg-white/5 dark:bg-black/5 p-6 rounded-xl">
                    <h3 class="text-xl font-bold mb-4">Répartition par Catégorie</h3>
                    <canvas id="categoryChart" class="w-full max-h-64"></canvas>
                </div>
                {{-- <div>Debug: {{ json_encode($categoriesData) }}</div> --}}

                <div class="bg-white/5 dark:bg-black/5 p-6 rounded-xl">
                    <h3 class="text-xl font-bold mb-4">Activité Mensuelle</h3>
                    {{-- <canvas id="activityChart" class="w-full h-64"></canvas> --}}
                </div>

            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log("Données catégories:", @json($categoriesData));

            const ctx = document.getElementById('categoryChart');
            if (!ctx) {
                console.error("Canvas non trouvé!");
                return;
            }

            const categoriesData = @json($categoriesData);

            if (!Array.isArray(categoriesData) || categoriesData.length === 0) {
                console.warn("Aucune donnée disponible");
                ctx.closest('div').innerHTML = '<p class="text-red-500">Aucune donnée disponible</p>';
                return;
            }

            try {
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: categoriesData.map(item => item.category_name || 'Non catégorisé'),
                        datasets: [{
                            data: categoriesData.map(item => item.book_count || 0),
                            backgroundColor: [
                                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                                '#9966FF', '#FF9F40', '#8AC24A', '#607D8B'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = total > 0 ? Math.round((value / total) *
                                            100) : 0;
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
                console.log("Graphique créé avec succès");
            } catch (error) {
                console.error("Erreur création graphique:", error);
                ctx.closest('div').innerHTML = '<p class="text-red-500">Erreur d\'affichage du graphique</p>';
            }
        });
    </script>



@endsection

