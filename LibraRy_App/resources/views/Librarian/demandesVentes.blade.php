@extends('layouts.admin-layout')

@section('title', 'Tableau de bord')
@section('header', 'Tableau de bord')

@section('content')
    <!-- Main Content -->
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-light-bg dark:bg-dark-bg p-6 gap-6">
        <!-- Mobile Sidebar Toggle -->
        <button id="sidebarToggle"
            class="md:hidden fixed top-4 left-4 z-30 p-2 rounded-lg bg-light-primary/20 dark:bg-dark-primary/20 mb-6">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col  md:flex-row justify-between items-center mb-8 mt-8 gap-4">
                <h1 class="text-3xl font-bold">Demandes de Ventes</h1>
                <div class="w-full md:w-auto">
                    <input type="text" id="searchInput" placeholder="Rechercher par titre ou utilisateur..."
                        class="w-full px-4 py-2 rounded-lg bg-light-primary/10 dark:bg-dark-primary/10 border-0 focus:ring-2 focus:ring-light-primary dark:focus:ring-dark-primary">
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-light-primary/10 dark:bg-dark-primary/10 p-6 rounded-xl animate-slide-up">
                    <h3 class="text-xl font-bold mb-2">Total des Demandes</h3>
                    <p class="text-3xl font-bold text-light-primary dark:text-dark-primary">45</p>
                    <p class="text-sm opacity-75">Ce mois</p>
                </div>
                <div class="bg-light-primary/10 dark:bg-dark-primary/10 p-6 rounded-xl animate-slide-up"
                    style="animation-delay: 0.2s">
                    <h3 class="text-xl font-bold mb-2">Utilisateurs Actifs</h3>
                    <p class="text-3xl font-bold text-light-primary dark:text-dark-primary">28</p>
                    <p class="text-sm opacity-75">Avec des demandes en cours</p>
                </div>
            </div>

            <!-- Requests Table -->
            <div class="bg-white/5 dark:bg-black/5 rounded-xl shadow-lg overflow-hidden animate-fade-in">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-light-primary/10 dark:border-dark-primary/10">
                                <th class="px-6 py-3 text-left">Livre</th>
                                <th class="px-6 py-3 text-left">Utilisateur</th>
                                <th class="px-6 py-3 text-left">Serial Code</th>
                                <th class="px-6 py-3 text-left">Date</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="requestsTableBody">
                            <!-- Les demandes seront ajoutées ici dynamiquement -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Données de test pour les demandes
        const requestsData = [{
                id: 1,
                book: 'Le Petit Prince',
                user: 'Jean Dupont',
                serialCode: 'LPP-2024-001',
                date: '2024-03-15',
                email: 'jean@email.com'
            },
            {
                id: 1,
                book: 'Le Petit Prince',
                user: 'Jean Dupont',
                serialCode: 'LPP-2024-001',
                date: '2024-03-15',
                email: 'jean@email.com'
            },
            {
                id: 1,
                book: 'Le Petit Prince',
                user: 'Jean Dupont',
                serialCode: 'LPP-2024-001',
                date: '2024-03-15',
                email: 'jean@email.com'
            },
            // ... autres demandes
        ];

        // Fonction pour remplir le tableau des demandes
        function populateRequestsTable(requests = requestsData) {
            const tableBody = document.getElementById('requestsTableBody');
            tableBody.innerHTML = '';

            requests.forEach(request => {
                const row = document.createElement('tr');
                row.className =
                    'border-b border-light-primary/10 dark:border-dark-primary/10 hover:bg-light-primary/5 dark:hover:bg-dark-primary/5 transition-colors';

                row.innerHTML = `
                <td class="px-6 py-4">${request.book}</td>
                <td class="px-6 py-4">${request.user}</td>
                <td class="px-6 py-4">${request.serialCode}</td>
                <td class="px-6 py-4">${request.date}</td>
                <td class="px-6 py-4">
                    <div class="flex justify-end space-x-2">
                        <button onclick="handleRequest(${request.id}, 'approve')"
                                class="p-2 rounded-lg hover:bg-light-primary/10 dark:hover:bg-dark-primary/10 text-green-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </button>
                        <button onclick="handleRequest(${request.id}, 'reject')"
                                class="p-2 rounded-lg hover:bg-light-primary/10 dark:hover:bg-dark-primary/10 text-red-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </td>
            `;

                tableBody.appendChild(row);
            });
        }

        // Fonction de recherche
        function handleSearch(event) {
            const searchTerm = event.target.value.toLowerCase();
            const filteredRequests = requestsData.filter(request =>
                request.book.toLowerCase().includes(searchTerm) ||
                request.user.toLowerCase().includes(searchTerm)
            );
            populateRequestsTable(filteredRequests);
        }

        // Fonction pour gérer les actions sur les demandes
        function handleRequest(requestId, action) {
            // Cette fonction sera implémentée avec le backend
            console.log(`Request ${requestId} ${action}ed`);
        }

        // Fonction pour gérer le sidebar responsive
        function initSidebar() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const overlay = document.createElement('div');

            // Créer l'overlay pour le mobile
            overlay.className = 'fixed inset-0 bg-black/50 z-10 hidden md:hidden';
            document.body.appendChild(overlay);

            // Fonction pour fermer le sidebar
            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            // Fonction pour ouvrir le sidebar
            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            // Toggle sidebar
            sidebarToggle.addEventListener('click', () => {
                if (sidebar.classList.contains('-translate-x-full')) {
                    openSidebar();
                } else {
                    closeSidebar();
                }
            });

            // Fermer le sidebar quand on clique sur l'overlay
            overlay.addEventListener('click', closeSidebar);

            // Fermer le sidebar quand l'écran devient plus grand
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 768) { // 768px est la breakpoint md de Tailwind
                    closeSidebar();
                }
            });

            // Fermer le sidebar quand on clique sur un lien (en mobile)
            const sidebarLinks = sidebar.querySelectorAll('a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 768) {
                        closeSidebar();
                    }
                });
            });
        }

        // Fonction pour gérer le mode sombre
        function initDarkMode() {
            const darkModeToggle = document.getElementById('darkModeToggle');
            const html = document.documentElement;

            // Vérifier le mode actuel
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            if (isDarkMode) {
                html.classList.add('dark');
                darkModeToggle.textContent = 'Mode Clair';
            }

            // Toggle dark mode
            darkModeToggle.addEventListener('click', () => {
                html.classList.toggle('dark');
                const isDark = html.classList.contains('dark');
                localStorage.setItem('darkMode', isDark);
                darkModeToggle.textContent = isDark ? 'Mode Clair' : 'Mode Sombre';
            });
        }

        // Initialiser les fonctionnalités au chargement de la page
        document.addEventListener('DOMContentLoaded', () => {
            initSidebar();
            initDarkMode();
            populateRequestsTable();
        });
    </script>
@endsection
