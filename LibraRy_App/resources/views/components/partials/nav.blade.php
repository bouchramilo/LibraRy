<header x-data="{ isOpen: false }" class="fixed w-full z-50 bg-light-bg dark:bg-dark-bg dark:shadow-black shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <h1 class="text-2xl font-bold text-light-primary dark:text-dark-primary">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <svg class="w-8 h-8 mr-2 text-light-primary dark:text-dark-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        LibraRy
                    </a>
                </h1>
            </div>

            <!-- Navigation Desktop -->
            <nav class="hidden md:flex space-x-4 items-center sm:-my-px sm:ms-10 sm:flex">
                <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                    {{ __('Accueil') }}
                </x-nav-link>

                @guest
                    <x-nav-link :href="route('client.catalogue')" :active="request()->routeIs('client.catalogue')">
                        {{ __('Catalogue') }}
                    </x-nav-link>
                    <x-nav-link :href="route('auth.login.show')" :active="request()->routeIs('auth.login.show')">
                        {{ __('Connexion') }}
                    </x-nav-link>
                    <x-nav-link :href="route('auth.register.show')" :active="request()->routeIs('auth.register.show')">
                        {{ __('Inscription') }}
                    </x-nav-link>
                @endguest

                @auth
                    {{-- Bibliothécaire --}}
                    @if (Auth::user()->role === 'Bibliothécaire')
                        <x-nav-link :href="route('librarian.dashboard')" :active="request()->routeIs('librarian.dashboard')">
                            {{ __('Tableau de bord') }}
                        </x-nav-link>
                        <x-nav-link :href="route('librarian.emprunts.index')" :active="request()->routeIs('librarian.emprunts.index')">
                            {{ __('Emprunts') }}
                        </x-nav-link>
                        <x-nav-link :href="route('librarian.books.index')" :active="request()->routeIs('librarian.books.index')">
                            {{ __('Livres') }}
                        </x-nav-link>
                    @endif

                    {{-- Client --}}
                    @if (Auth::user()->role === 'Client')
                        <x-nav-link :href="route('client.dashboard')" :active="request()->routeIs('client.dashboard')">
                            {{ __('Tableau de bord') }}
                        </x-nav-link>
                        <x-nav-link :href="route('client.catalogue')" :active="request()->routeIs('client.catalogue')">
                            {{ __('Catalogue') }}
                        </x-nav-link>
                        <x-nav-link :href="route('client.emprunt.show')" :active="request()->routeIs('client.emprunt.show')">
                            {{ __('Mes emprunts') }}
                        </x-nav-link>
                    @endif

                    <x-nav-link :href="route('auth.profile.show')" :active="request()->routeIs('auth.profile.show')">
                        {{ __('Profil') }}
                    </x-nav-link>

                    <form action="{{ route('auth.logout') }}" method="POST">
                        @csrf
                        @method('POST')
                        <button type="submit" class="ml-4 px-4 py-2 rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 transition-colors duration-300">
                            {{ __('Déconnexion') }}
                        </button>
                    </form>
                @endauth

                <!-- Bouton de thème amélioré -->
                <button @click="darkMode = !darkMode" id="darkModeToggle"
                    class="ml-4 p-2 rounded-full hover:bg-light-primary/20 dark:hover:bg-dark-primary/20 transition-all duration-300 relative"
                    aria-label="Changer de thème">
                    <!-- Animation de transition -->
                    <div class="relative w-6 h-6 overflow-hidden">
                        <!-- Icône de lune (dark mode) -->
                        <svg x-show="darkMode" x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform -translate-y-4"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 transform translate-y-0"
                             x-transition:leave-end="opacity-0 transform translate-y-4"
                             class="absolute w-5 h-5 text-yellow-300" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                  d="M9.528 1.718a.75.75 0 01.162.819A8.97 8.97 0 009 6a9 9 0 009 9 8.97 8.97 0 003.463-.69.75.75 0 01.981.98 10.503 10.503 0 01-9.694 6.46c-5.799 0-10.5-4.701-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 01.818.162z"
                                  clip-rule="evenodd" />
                        </svg>

                        <!-- Icône soleil (light mode) -->
                        <svg x-show="!darkMode" x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform -translate-y-4"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 transform translate-y-0"
                             x-transition:leave-end="opacity-0 transform translate-y-4"
                             class="absolute w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.591 1.59a.75.75 0 101.06 1.061l1.591-1.59zM21.75 12a.75.75 0 01-.75.75h-2.25a.75.75 0 010-1.5H21a.75.75 0 01.75.75zM17.834 18.894a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 10-1.061 1.06l1.59 1.591zM12 18a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-2.25A.75.75 0 0112 18zM7.758 17.303a.75.75 0 00-1.061-1.06l-1.591 1.59a.75.75 0 001.06 1.061l1.591-1.59zM6 12a.75.75 0 01-.75.75H3a.75.75 0 010-1.5h2.25A.75.75 0 016 12zM6.697 7.757a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 00-1.061 1.06l1.59 1.591z" />
                        </svg>
                    </div>
                </button>
            </nav>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button @click="isOpen = !isOpen" class="p-2" aria-label="Menu mobile">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!isOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="isOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="isOpen" x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="md:hidden origin-top-right absolute right-0 left-0 mt-2 rounded-b-lg shadow-lg bg-white dark:bg-dark-primary/10 ring-1 ring-black ring-opacity-5 focus:outline-none">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 grid grid-cols-1">
            <x-nav-link class="block px-3 py-2 rounded-md text-base font-medium"
                :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Accueil') }}
            </x-nav-link>

            @guest
                <x-nav-link class="block px-3 py-2 rounded-md text-base font-medium"
                    :href="route('client.catalogue')" :active="request()->routeIs('client.catalogue')">
                    {{ __('Catalogue') }}
                </x-nav-link>
                <x-nav-link class="block px-3 py-2 rounded-md text-base font-medium"
                    :href="route('auth.login.show')" :active="request()->routeIs('auth.login.show')">
                    {{ __('Connexion') }}
                </x-nav-link>
                <x-nav-link class="block px-3 py-2 rounded-md text-base font-medium"
                    :href="route('auth.register.show')" :active="request()->routeIs('auth.register.show')">
                    {{ __('Inscription') }}
                </x-nav-link>
            @endguest

            @auth
                @if (Auth::user()->role === 'Bibliothécaire')
                    <x-nav-link class="block px-3 py-2 rounded-md text-base font-medium"
                        :href="route('librarian.dashboard')" :active="request()->routeIs('librarian.dashboard')">
                        {{ __('Tableau de bord') }}
                    </x-nav-link>
                    <x-nav-link class="block px-3 py-2 rounded-md text-base font-medium"
                        :href="route('librarian.emprunts.index')" :active="request()->routeIs('librarian.emprunts.index')">
                        {{ __('Emprunts') }}
                    </x-nav-link>
                    <x-nav-link class="block px-3 py-2 rounded-md text-base font-medium"
                        :href="route('librarian.books.index')" :active="request()->routeIs('librarian.books.index')">
                        {{ __('Livres') }}
                    </x-nav-link>
                @endif

                @if (Auth::user()->role === 'Client')
                    <x-nav-link class="block px-3 py-2 rounded-md text-base font-medium"
                        :href="route('client.dashboard')" :active="request()->routeIs('client.dashboard')">
                        {{ __('Tableau de bord') }}
                    </x-nav-link>
                    <x-nav-link class="block px-3 py-2 rounded-md text-base font-medium"
                        :href="route('client.catalogue')" :active="request()->routeIs('client.catalogue')">
                        {{ __('Catalogue') }}
                    </x-nav-link>
                    <x-nav-link class="block px-3 py-2 rounded-md text-base font-medium"
                        :href="route('client.emprunt.show')" :active="request()->routeIs('client.emprunt.show')">
                        {{ __('Mes emprunts') }}
                    </x-nav-link>
                @endif

                <x-nav-link class="block px-3 py-2 rounded-md text-base font-medium"
                    :href="route('auth.profile.show')" :active="request()->routeIs('auth.profile.show')">
                    {{ __('Profil') }}
                </x-nav-link>

                <form action="{{ route('auth.logout') }}" method="POST">
                    @csrf
                    @method('POST')
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">
                        {{ __('Déconnexion') }}
                    </button>
                </form>
            @endauth

            <!-- Bouton de thème mobile -->
            <button @click="darkMode = !darkMode"
                class="w-full flex items-center px-3 py-2 rounded-md text-base font-medium hover:bg-light-primary/10 dark:hover:bg-dark-primary/20 transition-colors duration-300"
                aria-label="Changer de thème">
                <svg x-show="darkMode" class="w-5 h-5 mr-3 text-yellow-300" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                          d="M9.528 1.718a.75.75 0 01.162.819A8.97 8.97 0 009 6a9 9 0 009 9 8.97 8.97 0 003.463-.69.75.75 0 01.981.98 10.503 10.503 0 01-9.694 6.46c-5.799 0-10.5-4.701-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 01.818.162z"
                          clip-rule="evenodd" />
                </svg>
                <svg x-show="!darkMode" class="w-5 h-5 mr-3 text-orange-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.591 1.59a.75.75 0 101.06 1.061l1.591-1.59zM21.75 12a.75.75 0 01-.75.75h-2.25a.75.75 0 010-1.5H21a.75.75 0 01.75.75zM17.834 18.894a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 10-1.061 1.06l1.59 1.591zM12 18a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-2.25A.75.75 0 0112 18zM7.758 17.303a.75.75 0 00-1.061-1.06l-1.591 1.59a.75.75 0 001.06 1.061l1.591-1.59zM6 12a.75.75 0 01-.75.75H3a.75.75 0 010-1.5h2.25A.75.75 0 016 12zM6.697 7.757a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 00-1.061 1.06l1.59 1.591z" />
                </svg>
                <span x-text="darkMode ? 'Passer en mode clair' : 'Passer en mode sombre'"></span>
            </button>
        </div>
    </div>
</header>
