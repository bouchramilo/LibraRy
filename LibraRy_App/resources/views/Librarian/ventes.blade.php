@extends('layouts.admin-layout')

@section('title', 'Tableau de bord')
@section('header', 'Tableau de bord')

@section('content')
    <!-- Main Content -->
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-light-bg dark:bg-dark-bg p-6 gap-6">
        <!-- Mobile Sidebar Toggle -->
        <button id="sidebarToggle"
            class="md:hidden fixed top-4 left-4 z-30 p-2 rounded-lg bg-light-primary/20 dark:bg-dark-primary/20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col  md:flex-row justify-between items-center mb-8 mt-8 gap-4">
                <h1 class="text-3xl font-bold">Gestion des Ventes</h1>
                <div class="flex space-x-4 w-1/2">
                    <select id="periodFilter"
                        class="w-full px-4 py-2 rounded-lg bg-light-primary/10 dark:bg-dark-primary/10 border-0 focus:ring-2 focus:ring-light-primary dark:focus:ring-dark-primary">
                        <option value="week">Cette semaine</option>
                        <option value="month">Ce mois</option>
                        <option value="year">Cette année</option>
                    </select>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-light-primary/10 dark:bg-dark-primary/10 p-6 rounded-xl animate-slide-up">
                    <h3 class="text-xl font-bold mb-2">Ventes Totales</h3>
                    <p class="text-3xl font-bold text-light-primary dark:text-dark-primary">2,500 €</p>
                    <p class="text-sm opacity-75">+15% ce mois</p>
                </div>
                <div class="bg-light-primary/10 dark:bg-dark-primary/10 p-6 rounded-xl animate-slide-up">
                    <h3 class="text-xl font-bold mb-2">Nombre de Ventes</h3>
                    <p class="text-3xl font-bold text-light-primary dark:text-dark-primary">85</p>
                    <p class="text-sm opacity-75">Cette semaine</p>
                </div>
                <div class="bg-light-primary/10 dark:bg-dark-primary/10 p-6 rounded-xl animate-slide-up">
                    <h3 class="text-xl font-bold mb-2">En Attente</h3>
                    <p class="text-3xl font-bold text-light-accent dark:text-dark-accent">12</p>
                    <p class="text-sm opacity-75">À valider</p>
                </div>
            </div>

            <!-- Sales Chart -->
            {{-- <div class="bg-white/5 dark:bg-black/5 p-6 rounded-xl mb-8 animate-fade-in">
                <canvas id="salesChart" class="w-full h-64"></canvas>
            </div> --}}

            <!-- Sales Table -->
            <div class="bg-white/5 dark:bg-black/5 rounded-xl shadow-lg overflow-hidden animate-fade-in">
                <div class="p-6 border-b border-light-primary/10 dark:border-dark-primary/10">
                    <h2 class="text-2xl font-bold">Dernières Ventes</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-light-primary/10 dark:border-dark-primary/10">
                                <th class="px-6 py-3 text-left">Livre</th>
                                <th class="px-6 py-3 text-left">Client</th>
                                <th class="px-6 py-3 text-left">Serial Code</th>
                                <th class="px-6 py-3 text-left">Date</th>
                                <th class="px-6 py-3 text-left">Montant</th>
                                <th class="px-6 py-3 text-left">Statut</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="salesTableBody">
                            <tr
                                class="border-b border-light-primary/10 dark:border-dark-primary/10 hover:bg-light-primary/5 dark:hover:bg-dark-primary/5 transition-colors">
                                <td class="px-6 py-4">${sale.book}</td>
                                <td class="px-6 py-4">${sale.client}</td>
                                <td class="px-6 py-4">${sale.serialCode}</td>
                                <td class="px-6 py-4">${sale.date}</td>
                                <td class="px-6 py-4">${sale.amount} €</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 rounded-full text-sm ${
                                        sale.status === 'Validé'
                                        ? 'bg-green-500/10 text-green-500'
                                        : 'bg-yellow-500/10 text-yellow-500'
                                    }">${sale.status}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-end space-x-2">
                                        <button onclick="showSaleDetails(${sale.id})"
                                            class="p-2 rounded-lg hover:bg-light-primary/10 dark:hover:bg-dark-primary/10 text-light-accent dark:text-dark-accent transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </button>
                                        ${sale.status === 'En attente' ? `
                                        <button
                                            class="p-2 rounded-lg hover:bg-light-primary/10 dark:hover:bg-dark-primary/10 text-green-500 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                        <button
                                            class="p-2 rounded-lg hover:bg-light-primary/10 dark:hover:bg-dark-primary/10 text-red-500 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                        ` : ''}
                                    </div>
                                </td>
                            </tr>
                            <!-- Les ventes seront ajoutées ici dynamiquement -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Sale Details Modal (using Alpine.js) -->
    <div x-data="{ showModal: false, selectedSale: null }" x-show="showModal" class="fixed inset-0 bg-black/50 flex items-center justify-center p-4">
        <div class="bg-light-bg dark:bg-dark-bg p-6 rounded-xl w-full max-w-md animate-slide-up">
            <h3 class="text-2xl font-bold mb-4">Détails de la Vente</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Client</label>
                    <p x-text="selectedSale?.client" class="p-2 bg-light-primary/5 dark:bg-dark-primary/5 rounded-lg"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <p x-text="selectedSale?.email" class="p-2 bg-light-primary/5 dark:bg-dark-primary/5 rounded-lg"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Téléphone</label>
                    <p x-text="selectedSale?.phone" class="p-2 bg-light-primary/5 dark:bg-dark-primary/5 rounded-lg"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Adresse</label>
                    <p x-text="selectedSale?.address" class="p-2 bg-light-primary/5 dark:bg-dark-primary/5 rounded-lg">
                    </p>
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button @click="showModal = false"
                        class="px-4 py-2 rounded-lg bg-light-primary/10 dark:bg-dark-primary/10 hover:bg-light-primary/20 dark:hover:bg-dark-primary/20 transition-colors">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Données de test pour les ventes
        const salesData = [{
                id: 1,
                book: 'Le Petit Prince',
                client: 'Jean Dupont',
                serialCode: 'LPP-2024-001',
                date: '2024-03-15',
                amount: 25,
                status: 'En attente',
                email: 'jean@email.com',
                phone: '0123456789',
                address: '123 Rue de Paris'
            },
            {
                id: 2,
                book: '1984',
                client: 'Marie Martin',
                serialCode: '1984-2024-002',
                date: '2024-03-14',
                amount: 30,
                status: 'Validé',
                email: 'marie@email.com',
                phone: '0123456788',
                address: '456 Avenue Victor Hugo'
            }
        ];

        // Fonction pour remplir le tableau des ventes
        function populateSalesTable() {
            const tableBody = document.getElementById('salesTableBody');
            tableBody.innerHTML = '';

            salesData.forEach(sale => {
                const row = document.createElement('tr');
                row.className =
                    'border-b border-light-primary/10 dark:border-dark-primary/10 hover:bg-light-primary/5 dark:hover:bg-dark-primary/5 transition-colors';

                row.innerHTML = `
                    <td class="px-6 py-4">${sale.book}</td>
                    <td class="px-6 py-4">${sale.client}</td>
                    <td class="px-6 py-4">${sale.serialCode}</td>
                    <td class="px-6 py-4">${sale.date}</td>
                    <td class="px-6 py-4">${sale.amount} €</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-sm ${
                            sale.status === 'Validé'
                            ? 'bg-green-500/10 text-green-500'
                            : 'bg-yellow-500/10 text-yellow-500'
                        }">${sale.status}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-end space-x-2">
                            <button onclick="showSaleDetails(${sale.id})"
                                    class="p-2 rounded-lg hover:bg-light-primary/10 dark:hover:bg-dark-primary/10 text-light-accent dark:text-dark-accent transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                            ${sale.status === 'En attente' ? `
                                    <button class="p-2 rounded-lg hover:bg-light-primary/10 dark:hover:bg-dark-primary/10 text-green-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </button>
                                    <button class="p-2 rounded-lg hover:bg-light-primary/10 dark:hover:bg-dark-primary/10 text-red-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                ` : ''}
                        </div>
                    </td>
                `;

                tableBody.appendChild(row);
            });
        }

        // Fonction pour afficher les détails d'une vente
        function showSaleDetails(saleId) {
            const sale = salesData.find(s => s.id === saleId);
            if (sale) {
                // Utilise Alpine.js pour afficher le modal
                const modal = document.querySelector('[x-data]').__x.$data;
                modal.selectedSale = sale;
                modal.showModal = true;
            }
        }

        // Gestionnaire du dark mode
        function initDarkMode() {
            const darkModeToggle = document.getElementById('darkModeToggle');
            const html = document.documentElement;

            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            if (isDarkMode) {
                html.classList.add('dark');
                darkModeToggle.textContent = 'Mode Clair';
            } else {
                darkModeToggle.textContent = 'Mode Sombre';
            }

            darkModeToggle.addEventListener('click', () => {
                html.classList.toggle('dark');
                const isDark = html.classList.contains('dark');
                localStorage.setItem('darkMode', isDark);
                darkModeToggle.textContent = isDark ? 'Mode Clair' : 'Mode Sombre';
            });
        }

        // Gestionnaire du sidebar mobile
        function initSidebar() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');

            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
        }

        // Initialisation
        document.addEventListener('DOMContentLoaded', () => {
            initDarkMode();
            initSidebar();
            populateSalesTable();

            // Initialisation du graphique
            const ctx = document.getElementById('salesChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
                    datasets: [{
                        label: 'Ventes mensuelles',
                        data: [1200, 1900, 2500, 2800, 3200, 2500],
                        borderColor: '#a67a59',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#a67a59',
                                opacity: 0.1
                            }
                        },
                        x: {
                            grid: {
                                color: '#a67a59',
                                opacity: 0.1
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
