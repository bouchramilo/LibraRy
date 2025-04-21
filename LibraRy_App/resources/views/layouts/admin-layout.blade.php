<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Bhaijaan+2:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: {
                            text: '#cabfb4',
                            bg: '#1b1809',
                            primary: '#a67a59',
                            secondary: '#be9d93',
                            accent: '#45bfde'
                        },
                        light: {
                            text: '#4b4035',
                            bg: '#f6f3e4',
                            primary: '#a67a59',
                            secondary: '#6c4b41',
                            accent: '#219cba'
                        }
                    },
                    fontSize: {
                        'sm': '0.750rem',
                        'base': '1rem',
                        'xl': '1.333rem',
                        '2xl': '1.777rem',
                        '3xl': '2.369rem',
                        '4xl': '3.158rem',
                        '5xl': '4.210rem',
                    },
                    fontFamily: {
                        'heading': ['Baloo Bhaijaan 2', 'sans-serif'],
                        'body': ['Baloo Bhaijaan 2', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
</head>

<body class="font-body bg-light-bg dark:bg-dark-bg text-light-text dark:text-dark-text">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        {{-- <aside id="sidebar"
            class="fixed md:relative z-20 w-64 h-full transform transition-transform duration-300 bg-light-bg dark:bg-dark-bg shadow-lg">
            <div class="h-full flex flex-col justify-between p-4">
                <div class="space-y-4">
                    <!-- Admin Profile -->
                    <div class="flex flex-col items-center space-y-1">
                        <img src="https://ui-avatars.com/api/?name=Admin+User" alt="Admin"
                            class="w-14 h-14 rounded-full border-2 border-light-primary dark:border-dark-primary">
                        <div class="text-center">
                            <h2 class="font-bold">Admin User</h2>
                            <p class="text-sm opacity-75">admin@bibliotech.com</p>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <nav class="space-y-1">
                        <a href="dashboard_admin.html"
                            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-light-primary/20 dark:hover:bg-dark-primary/20 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                            <span>Tableau de bord</span>
                        </a>
                        <a href="manage_users.html"
                            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-light-primary/20 dark:hover:bg-dark-primary/20 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                            <span>Utilisateurs</span>
                        </a>
                        <a href="manage_books.html"
                            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-light-primary/20 dark:hover:bg-dark-primary/20 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                            <span>Livres</span>
                        </a>
                        <a href="manage_ventes.html"
                            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-light-primary/20 dark:hover:bg-dark-primary/20 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3v18h18M7 14l3-3 4 4 5-5"></path>
                            </svg>
                            <span>Ventes</span>
                        </a>
                        <a href="manage_demande_ventes.html"
                            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-light-primary/20 dark:hover:bg-dark-primary/20 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                            <span>Demandes de ventes</span>
                        </a>
                        <a href="manage_emprunts.html"
                            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-light-primary/20 dark:hover:bg-dark-primary/20 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Emprunts</span>
                        </a>
                        <a href="manage_retours.html"
                            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-light-primary/20 dark:hover:bg-dark-primary/20 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z">
                                </path>
                            </svg>
                            <span>Retours</span>
                        </a>
                    </nav>
                </div>

                <!-- Bottom Actions -->
                <div class="space-y-4">
                    <button id="darkModeToggle"
                        class="w-full p-3 rounded-lg bg-light-primary/20 dark:bg-dark-primary/20 hover:bg-light-primary/30 dark:hover:bg-dark-primary/30 transition-colors">
                        Mode Sombre
                    </button>
                    <button
                        class="w-full p-3 rounded-lg bg-red-500/10 hover:bg-red-500/20 text-red-500 transition-colors">
                        Déconnexion
                    </button>
                </div>
            </div>
        </aside> --}}
        <x-partials.sideBar />

        <!-- Main Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-light-bg dark:bg-dark-bg p-6">
            <!-- Mobile Sidebar Toggle -->
            <button id="sidebarToggle"
                class="md:hidden fixed top-4 left-4 z-30 p-2 rounded-lg bg-light-primary/20 dark:bg-dark-primary/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>

            <main class="max-w-7xl mx-auto">
                @yield('content')
            </main>
        </main>

        <!-- Modal (using Alpine.js) -->
        <div x-data="{ showModal: false, selectedCategory: null }" x-show="showModal"
            class="fixed inset-0 bg-black/50 flex items-center justify-center p-4">
            <div class="bg-light-bg dark:bg-dark-bg p-6 rounded-xl w-full max-w-md">
                <!-- Modal content -->
                <x-input-text></x-input-text>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');

            sidebarToggle?.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
            });

            const darkModeToggle = document.getElementById('darkModeToggle');
            const html = document.documentElement;

            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            if (isDarkMode) {
                html.classList.add('dark');
                updateDarkModeText();
            }

            darkModeToggle?.addEventListener('click', function() {
                html.classList.toggle('dark');
                localStorage.setItem('darkMode', html.classList.contains('dark'));
                updateDarkModeText();
            });

            function updateDarkModeText() {
                const isDark = html.classList.contains('dark');
                document.querySelector('.dark-mode-text').classList.toggle('hidden', !isDark);
                document.querySelector('.light-mode-text').classList.toggle('hidden', isDark);
            }

            const addCategoryForm = document.getElementById('addCategoryForm');
            addCategoryForm?.addEventListener('submit', function(e) {
                e.preventDefault();
                const categoryName = document.getElementById('categoryName').value;
                if (categoryName.trim()) {
                    console.log('Adding category:', categoryName);
                    this.reset();
                }
            });
        });


    </script>
</body>

</html>
