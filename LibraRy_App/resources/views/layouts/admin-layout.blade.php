<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Bhaijaan+2:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    {{--  --}}
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Bhaijaan+2:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{--  --}}
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
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Animations avancées */
        @keyframes slideIn {
            from {
                transform: translateX(-100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes scaleIn {
            from {
                transform: scale(0.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-slide-in {
            animation: slideIn 0.5s ease-out;
        }

        .animate-fade-up {
            animation: fadeUp 0.5s ease-out;
        }

        .animate-scale-in {
            animation: scaleIn 0.3s ease-out;
        }

        /* Transition mode sombre/clair */
        .theme-transition {
            transition: background-color 0.5s ease-in-out,
                color 0.5s ease-in-out,
                border-color 0.5s ease-in-out,
                box-shadow 0.5s ease-in-out;
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

        @keyframes slideIn {
            from {
                transform: translateX(-100%);
            }

            to {
                transform: translateX(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        .slide-in {
            animation: slideIn 0.5s ease-out forwards;
        }

        .transition-theme {
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>

<body class="font-body bg-light-bg dark:bg-dark-bg text-light-text dark:text-dark-text">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
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


    </div>
</body>

<script>
    var tagSelector = new MultiSelectTag('categories', {
        maxSelection: 5,
        required: true,
        placeholder: 'Search tags', // default 'Search'.
        onChange: function(selected) { // Callback when selection changes.
            console.log('Selection changed:', selected);
        }
    });
</script>
<script>
    // Fonctions JavaScript pour la gestion des utilisateurs
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle Sidebar
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');

        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('-translate-x-full');
        });

        // Responsive sidebar
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('-translate-x-full');
            }
        });

        // Dark Mode Toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        const html = document.documentElement;

        const isDarkMode = localStorage.getItem('darkMode') === 'true';
        if (isDarkMode) {
            html.classList.add('dark');
        }

        darkModeToggle.addEventListener('click', function() {
            html.classList.toggle('dark');
            localStorage.setItem('darkMode', html.classList.contains('dark'));
        });


    });
</script>

</html>
