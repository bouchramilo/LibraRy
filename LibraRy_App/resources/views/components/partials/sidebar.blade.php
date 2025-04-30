<!-- Sidebar -->
<aside id="sidebar"
    class="fixed md:relative z-20 w-64 h-full transform transition-transform duration-300 bg-light-bg dark:bg-dark-bg shadow-lg">
    <div class="h-full flex flex-col justify-between p-4">
        <div class="space-y-4">
            <!-- Admin Profile -->
            <div class="flex flex-col items-center space-y-1">
                <a href="/profile">
                    <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('images/default-avatar.jpg') }}"
                        alt="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}"
                        class="w-14 h-14 rounded-full border-2 border-light-primary dark:border-dark-primary">
                </a>
                <div class="text-center">
                    <h2 class="font-bold">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h2>
                    <p class="text-sm opacity-75">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="space-y-1">
                <x-sidebar-link :href="route('home')" :active="request()->routeIs('home')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span>Accueil</span>
                </x-sidebar-link>
                <x-sidebar-link :href="route('librarian.dashboard')" :active="request()->routeIs('librarian.dashboard')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h7v7H3V3zm0 11h7v7H3v-7zm11-11h7v7h-7V3zm0 11h7v7h-7v-7z" />
                    </svg>
                    <span>Tableau de bord</span>
                </x-sidebar-link>

                <x-sidebar-link :href="route('manage.users.index')" :active="request()->routeIs('manage.users.index')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <span>Utilisateurs</span>
                </x-sidebar-link>
                <x-sidebar-link :href="route('manage.categories.index')" :active="request()->routeIs('manage.categories.index')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 19.5A2.5 2.5 0 006.5 22H20M4 15.5A2.5 2.5 0 006.5 18H20M4 11.5A2.5 2.5 0 006.5 14H20M4 7.5A2.5 2.5 0 006.5 10H20M4 3.5A2.5 2.5 0 006.5 6H20" />
                    </svg>
                    <span>Catégories</span>
                </x-sidebar-link>
                <x-sidebar-link :href="route('librarian.books.index')" :active="request()->routeIs('librarian.books.index')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 20l-4-2H5a2 2 0 01-2-2V6a2 2 0 012-2h3l4 2m0 0l4-2h3a2 2 0 012 2v10a2 2 0 01-2 2h-3l-4 2m0-13v13" />
                    </svg>
                    <span>Livres</span>
                </x-sidebar-link>
                <x-sidebar-link :href="route('librarian.exemplaires.index')" :active="request()->routeIs('librarian.exemplaires.index')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 6v12a1 1 0 001 1h14M21 6v12a1 1 0 01-1 1H7M3 6a1 1 0 011-1h14a1 1 0 011 1" />
                    </svg>
                    <span>Exemplaires</span>
                </x-sidebar-link>

                <x-sidebar-link :href="route('librarian.ventes.index')" :active="request()->routeIs('librarian.ventes.index')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3v18h18M7 14l3-3 4 4 5-5"></path>
                    </svg>
                    <span>Ventes</span>
                </x-sidebar-link>
                <x-sidebar-link :href="route('librarian.emprunts.index')" :active="request()->routeIs('librarian.emprunts.index')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Emprunts</span>
                </x-sidebar-link>
                <x-sidebar-link :href="route('librarian.retours.index')" :active="request()->routeIs('librarian.retours.index')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z">
                        </path>
                    </svg>
                    <span>Retours</span>
                </x-sidebar-link>
            </nav>
        </div>

        <!-- Bottom Actions -->
        <div class="space-y-4">
            <button id="darkModeToggle"
                class="w-full p-3 rounded-lg bg-light-primary/20 dark:bg-dark-primary/20 hover:bg-light-primary/30 dark:hover:bg-dark-primary/30 transition-colors">
                Mode Sombre
            </button>
            <form action="{{ route('auth.logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full p-3 rounded-lg bg-red-500/10 hover:bg-red-500/20 text-red-500 transition-colors">
                    Déconnexion </button>
            </form>
        </div>
    </div>

</aside>
