@extends('layouts.admin-layout')

@section('title', 'Tableau de bord')
@section('header', 'Tableau de bord')

@section('content')
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-light-bg dark:bg-dark-bg p-6">
       

        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-center my-8 gap-4">
                <h1 class="text-3xl font-bold w-full">Tableau de Bord</h1>
                <div class="flex space-x-4 w-full">
                    <select id="periodFilter"
                        class="w-full px-4 py-2 rounded-lg bg-light-primary/10 dark:bg-dark-primary/10 border-0 focus:ring-2 focus:ring-light-primary dark:focus:ring-dark-primary">
                        <option value="today">Aujourd'hui</option>
                        <option value="week">Cette semaine</option>
                        <option value="month">Ce mois</option>
                        <option value="year">Cette année</option>
                    </select>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Total Books -->
                <div class="stat-card bg-light-primary/10 dark:bg-dark-primary/10 p-6 rounded-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-2">Total des Livres</h3>
                            <p class="text-3xl font-bold text-light-primary dark:text-dark-primary" id="totalBooks">2,500
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

                <!-- Borrowed Books -->
                <div class="stat-card bg-light-primary/10 dark:bg-dark-primary/10 p-6 rounded-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-2">Livres Empruntés</h3>
                            <p class="text-3xl font-bold text-light-accent dark:text-dark-accent" id="borrowedBooks">485</p>
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
                            <p class="text-3xl font-bold text-yellow-500" id="pendingBorrows">32</p>
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

                <!-- Total Sales Amount -->
                <div class="stat-card bg-light-primary/10 dark:bg-dark-primary/10 p-6 rounded-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-2">Montant Ventes</h3>
                            <p class="text-3xl font-bold text-blue-500" id="salesAmount">5,780 €</p>
                        </div>
                        <div class="p-4 bg-blue-500/20 rounded-lg">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3v18h18M7 14l3-3 4 4 5-5"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white/5 dark:bg-black/5 p-6 rounded-xl">
                    <h3 class="text-xl font-bold mb-4">Répartition par Catégorie</h3>
                    <!-- <canvas id="categoryChart" class="w-full h-64"></canvas> -->
                </div>

                <div class="bg-white/5 dark:bg-black/5 p-6 rounded-xl">
                    <h3 class="text-xl font-bold mb-4">Activité Mensuelle</h3>
                    <!-- <canvas id="activityChart" class="w-full h-64"></canvas> -->
                </div>
            </div>
        </div>
    </main>
@endsection
