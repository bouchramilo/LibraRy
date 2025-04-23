 <!-- Sidebar -->
 <aside id="sidebar"
 class="fixed md:relative z-20 w-64 h-full transform transition-transform duration-300 bg-light-bg dark:bg-dark-bg shadow-lg">
 <div class="h-full flex flex-col justify-between p-4">
     <div class="space-y-4">
         <!-- Admin Profile -->
         <div class="flex flex-col items-center space-y-1">
             <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('images/default-avatar.jpg') }}" alt="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}" class="w-14 h-14 rounded-full border-2 border-light-primary dark:border-dark-primary">
             <div class="text-center">
                 <h2 class="font-bold">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h2>
                 <p class="text-sm opacity-75">{{ Auth::user()->email }}</p>
             </div>
         </div>

         <!-- Navigation -->
         <nav class="space-y-1">
             <a href="/admin/dashboard" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-light-primary/20 dark:hover:bg-dark-primary/20 transition-colors">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                 </svg>
                 <span>Tableau de bord</span>
             </a>
             <a href="/admin/users" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-light-primary/20 dark:hover:bg-dark-primary/20 transition-colors">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                 </svg>
                 <span>Utilisateurs</span>
             </a>
             <a href="/admin/categories" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-light-primary/20 dark:hover:bg-dark-primary/20 transition-colors">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                 </svg>
                 <span>Catégories</span>
             </a>
             <a href="/admin/books" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-light-primary/20 dark:hover:bg-dark-primary/20 transition-colors">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                 </svg>
                 <span>Livres</span>
             </a>
             <a href="/admin/ventes" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-light-primary/20 dark:hover:bg-dark-primary/20 transition-colors">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18M7 14l3-3 4 4 5-5"></path>
                 </svg>
                 <span>Ventes</span>
             </a>
             <a href="/admin/demande-ventes" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-light-primary/20 dark:hover:bg-dark-primary/20 transition-colors">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                 </svg>
                 <span>Demandes de ventes</span>
             </a>
             <a href="/admin/emprunts" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-light-primary/20 dark:hover:bg-dark-primary/20 transition-colors">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                 </svg>
                 <span>Emprunts</span>
             </a>
             <a href="/admin/retours" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-light-primary/20 dark:hover:bg-dark-primary/20 transition-colors">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"></path>
                 </svg>
                 <span>Retours</span>
             </a>
         </nav>
     </div>

     <!-- Bottom Actions -->
     <div class="space-y-4">
         <button id="darkModeToggle" class="w-full p-3 rounded-lg bg-light-primary/20 dark:bg-dark-primary/20 hover:bg-light-primary/30 dark:hover:bg-dark-primary/30 transition-colors">
             Mode Sombre
         </button>
         <button class="w-full p-3 rounded-lg bg-red-500/10 hover:bg-red-500/20 text-red-500 transition-colors">
             Déconnexion
         </button>
     </div>
 </div>
</aside>
