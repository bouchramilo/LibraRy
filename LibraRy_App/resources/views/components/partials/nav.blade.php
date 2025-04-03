<header x-data="{ isOpen: false }" class="fixed w-full z-50 bg-light-background dark:bg-dark-background shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <h1 class="text-2xl font-bold text-light-primary dark:text-dark-primary">LibraRy</h1>
            </div>

            <!-- Navigation Desktop -->
            <nav class="hidden md:flex space-x-8 items-center">
                <a href="#"
                    class="text-light-text dark:text-dark-text hover:text-light-accent dark:hover:text-dark-accent transition-colors duration-300">Accueil</a>
                <a href="#"
                    class="text-light-text dark:text-dark-text hover:text-light-accent dark:hover:text-dark-accent transition-colors duration-300">Catalogue</a>
                <a href="#"
                    class="text-light-text dark:text-dark-text hover:text-light-accent dark:hover:text-dark-accent transition-colors duration-300">Connexion</a>
                <a href="#"
                    class="text-light-text dark:text-dark-text hover:text-light-accent dark:hover:text-dark-accent transition-colors duration-300">Inscription</a>

                <!-- Theme Toggle -->
                <button @click="darkMode = !darkMode"
                    class="p-2 rounded-lg hover:bg-light-primary/10 dark:hover:bg-dark-primary/10 transition-colors duration-300">
                    <svg x-show="!darkMode" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg x-show="darkMode" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </nav>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button @click="isOpen = !isOpen" class="p-2">
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
    <div x-show="isOpen" class="md:hidden" x-transition>
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="#"
                class="block px-3 py-2 text-light-text dark:text-dark-text hover:bg-light-primary/10 dark:hover:bg-dark-primary/10 rounded-md">Accueil</a>
            <a href="#"
                class="block px-3 py-2 text-light-text dark:text-dark-text hover:bg-light-primary/10 dark:hover:bg-dark-primary/10 rounded-md">Catalogue</a>
            <a href="#"
                class="block px-3 py-2 text-light-text dark:text-dark-text hover:bg-light-primary/10 dark:hover:bg-dark-primary/10 rounded-md">Connexion</a>
            <a href="#"
                class="block px-3 py-2 text-light-text dark:text-dark-text hover:bg-light-primary/10 dark:hover:bg-dark-primary/10 rounded-md">Inscription</a>
        </div>
    </div>
</header>
