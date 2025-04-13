<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: false }" :class="darkMode ? 'dark' : ''">

<head>
    <x-partials.head />
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>

<body
    class="font-body bg-light-background dark:bg-dark-background text-light-text dark:text-dark-text transition-colors duration-300">
    {{-- <!-- Header --> --}}
    <x-partials.nav />
    <main class="min-h-screen items-center justify-center px-4 py-28 flex-grow container mx-auto">
        <h1 class="text-3xl text-light-primary dark:text-dark-primary font-heading my-2">Mon Profil</h1>
        <section class="bg-light-background dark:bg-dark-background rounded-lg p-6 mb-8">
            <!-- Messages de statut -->
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition
                    class="mb-6 flex items-center p-4 bg-green-50 border-l-4 border-green-500 text-green-700 dark:bg-green-900 dark:bg-opacity-20 dark:border-green-400 dark:text-green-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <div class="flex-grow">{{ session('success') }}</div>
                    <button @click="show = false"
                        class="text-green-700 dark:text-green-200 hover:text-green-900 dark:hover:text-green-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            @if (session('update_profile_error'))
                <div x-data="{ show: true }" x-show="show" x-transition
                    class="mb-6 flex items-center p-4 bg-red-50 border-l-4 border-red-500 text-red-700 dark:bg-red-900 dark:bg-opacity-20 dark:border-red-400 dark:text-red-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="flex-grow">{{ session('update_profile_error') }}</div>
                    <button @click="show = false"
                        class="text-red-700 dark:text-red-200 hover:text-red-900 dark:hover:text-red-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif
            <h2 class="text-xl font-heading mb-6">Informations Personnelles</h2>


            <form class="w-full md:w-full space-y-4" action="{{ route('auth.profile.update') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Photo de profil -->
                    <div class="w-full md:w-1/4">
                        <div class="relative group">
                            <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('images/default-avatar.jpg') }}"
                                alt="Photo de profil"
                                class="w-full rounded-full aspect-square object-cover border-2 border-light-accent dark:border-dark-accent">
                            <label class="absolute bottom-0 right-0 cursor-pointer">
                                <span
                                    class=" w-10 h-10 bg-light-primary dark:bg-dark-primary text-white rounded-full flex items-center justify-center hover:transform hover:-translate-y-1 transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </span>
                                <input type="file" name="photo" class="hidden">
                            </label>
                            @error('photo')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Formulaire -->
                    <div class="w-full flex flex-col gap-4">
                        <!-- Prénom et Nom -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-label>Prénom</x-label>
                                <x-input-text type="text" value="{{ old('first_name', $user->first_name) }}"
                                    name="first_name" />
                                @error('first_name')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <x-label>Nom</x-label>
                                <x-input-text type="text" value="{{ old('last_name', $user->last_name) }}"
                                    name="last_name" />
                                @error('last_name')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Date de naissance -->
                        <div>
                            <x-label>Date de naissance</x-label>
                            <x-input-text type="date" value="{{ old('date_birth', $user->date_birth) }}"
                                name="date_birth" max="{{ now()->subYears(18)->format('Y-m-d') }}" />
                            @error('date_birth')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email et Téléphone -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-label>Email</x-label>
                                <x-input-text type="email" value="{{ old('email', $user->email) }}" name="email" />
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <x-label>Téléphone</x-label>
                                <x-input-text type="tel" value="{{ old('telephone', $user->telephone) }}"
                                    name="telephone" placeholder="0612345678" />
                                @error('telephone')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Adresse -->
                        <div>
                            <x-label>Adresse</x-label>
                            <x-textarea name="address">{{ old('address', $user->address) }}</x-textarea>
                            @error('address')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ville et Code postal -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-label>Ville</x-label>
                                <x-input-text type="text" value="{{ old('city', $user->city) }}"
                                    name="city" />
                                @error('city')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <x-label>Code postal</x-label>
                                <x-input-text type="text" value="{{ old('code_postal', $user->code_postal) }}"
                                    name="code_postal" pattern="\d{5}" title="5 chiffres requis" />
                                @error('code_postal')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Bouton de soumission -->
                        <button type="submit"
                            class="inline-block px-8 py-3 bg-light-primary dark:bg-dark-primary text-white rounded-md hover:transform hover:-translate-y-1 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-light-primary dark:focus:ring-dark-primary">
                            Sauvegarder
                        </button>
                    </div>
                </div>
            </form>
        </section>

        <section class="bg-light-background dark:bg-dark-background rounded-lg p-6 mb-8">
            <h2 class="text-xl font-heading mb-6">Changer le mot de passe</h2>

            @if (session('password_success'))
                <div x-data="{ show: true }" x-show="show" x-transition
                    class="mb-6 flex items-center p-4 bg-green-50 border-l-4 border-green-500 text-green-700 dark:bg-green-900 dark:bg-opacity-20 dark:border-green-400 dark:text-green-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <div class="flex-grow">{{ session('password_success') }}</div>
                    <button @click="show = false"
                        class="text-green-700 dark:text-green-200 hover:text-green-900 dark:hover:text-green-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            @if (session('password_error'))
                <div x-data="{ show: true }" x-show="show" x-transition
                    class="mb-6 flex items-center p-4 bg-red-50 border-l-4 border-red-500 text-red-700 dark:bg-red-900 dark:bg-opacity-20 dark:border-red-400 dark:text-red-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <div class="flex-grow">{{ session('password_success') }}</div>
                    <button @click="show = false"
                        class="text-red-700 dark:text-red-200 hover:text-red-900 dark:hover:text-red-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            <form class="space-y-4 max-w-md" action="{{ route('auth.profile.update.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div>
                    <x-label>Ancien mot de passe</x-label>
                    <x-input-text type="password" name="old_password" />
                    @error('old_password')
                        <div>
                            <p class="mt-1 text-sm text-red-700 dark:text-red-300">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div>
                    <x-label>Nouveau mot de passe</x-label>
                    <x-input-text type="password" name="new_password" />
                    @error('new_password')
                        <div>
                            <p class="mt-1 text-sm text-red-700 dark:text-red-300">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div>
                    <x-label>Confirmer le nouveau mot de passe</x-label>
                    <x-input-text type="password" name="new_password_confirmation" />
                    @error('new_password_confirmation')
                        <div>
                            <p class="mt-1 text-sm text-red-700 dark:text-red-300">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <button type="submit"
                    class="inline-block px-8 py-3 bg-light-primary dark:bg-dark-primary text-white rounded-md hover:transform hover:-translate-y-1 transition-all duration-300">
                    Modifier
                </button>
            </form>
        </section>

        <section class="bg-light-background dark:bg-dark-background rounded-lg p-6 mb-8">
            <h2 class="text-xl font-heading mb-6">Historique</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr
                            class="border-b border-light-secondary focus:outline-none focus:border-2 focus:border-light-accent">
                            <th class="py-2 px-4 text-left">Date</th>
                            <th class="py-2 px-4 text-left">Type</th>
                            <th class="py-2 px-4 text-left">Titre</th>
                            <th class="py-2 px-4 text-left">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="shadow-sm shadow-light-secondary">
                            <td class="py-2 px-4">15/03/2024</td>
                            <td class="py-2 px-4">Emprunt</td>
                            <td class="py-2 px-4">Les Misérables</td>
                            <td class="py-2 px-4"><span class="px-2 py-1 rounded bg-green-500/20 text-green-500">En
                                    cours</span></td>
                        </tr>
                        <tr class="shadow-sm shadow-light-secondary">
                            <td class="py-2 px-4">10/03/2024</td>
                            <td class="py-2 px-4">Achat</td>
                            <td class="py-2 px-4">Le Petit Prince</td>
                            <td class="py-2 px-4"><span
                                    class="px-2 py-1 rounded bg-blue-500/20 text-blue-500">Terminé</span></td>
                        </tr>
                        <tr class="shadow-sm shadow-light-secondary">
                            <td class="py-2 px-4">01/03/2024</td>
                            <td class="py-2 px-4">Emprunt</td>
                            <td class="py-2 px-4">1984</td>
                            <td class="py-2 px-4"><span
                                    class="px-2 py-1 rounded bg-gray-500/20 text-gray-500">Retourné</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="bg-red-500/10 rounded-lg p-6">
            <h2 class="text-xl font-heading mb-6 text-red-500">Supprimer mon compte</h2>
            <p class="mb-4">Attention : Cette action est irréversible. Toutes vos données seront définitivement
                supprimées.</p>
            <form class="space-y-4 max-w-md" action="{{ route('auth.profile.delete') }}" method="POST">
                @csrf
                @method('DELETE')
                <div>
                    <x-label>Confirmer votre mot de passe</x-label>
                    <x-input-text type="password" class=" border-red-500" name="password" />
                    @error('password')
                        <div>
                            <p class="mt-1 text-sm text-red-700 dark:text-red-300">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
                <button type="submit" class="rounded-md bg-red-500 text-white px-6 py-2">Supprimer mon
                    compte</button>
            </form>
        </section>
    </main>
    {{-- <!-- Footer --> --}}
    <x-partials.footer />
</body>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,
        easing: 'ease';
        once: true,
    });
</script>

</html>
