<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: false }" :class="darkMode ? 'dark' : ''">

<head>
    <x-partials.head />
</head>

<body
    class="font-body bg-light-bg dark:bg-dark-bg text-light-text dark:text-dark-text transition-colors duration-300">
    <!-- Header -->
    <x-partials.nav />
    <main class="min-h-screen flex items-center justify-center px-4 py-28">
        <div class="max-w-7xl w-full mx-auto grid md:grid-cols-2 gap-12 items-center">
            <!-- Image Section -->
            <div class="hidden md:block relative h-full ">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-light-primary/20 to-transparent dark:from-dark-primary/20 rounded-2xl">
                </div>
                <img src="../images/img2.jpeg" alt="Bibliothèque"
                    class="w-full h-full object-cover rounded-2xl shadow-2xl animate-float">
                <div class="absolute bottom-8 left-8 right-8 p-6 rounded-xl text-light-bg">
                    <h2 class="text-2xl font-bold mb-2">Bienvenue sur BiblioTech</h2>
                    <p class="text-sm opacity-90">Votre bibliothèque numérique personnelle, accessible partout, à tout
                        moment.</p>
                </div>
            </div>

            <!-- Login Form -->
            <div class="w-full mx-auto ">

                <div class="bg-white/5 dark:bg-black/5 p-8 rounded-2xl shadow-2xl dark:shadow-black backdrop-blur-sm">

                    <h2 class="text-3xl font-heading font-bold mb-8 text-center">Créer un compte</h2>
                    <form class="space-y-6" action="{{ route('auth.register.store') }}" enctype="multipart/form-data"
                        method="POST">
                        @csrf
                        @method('POST')
                        <!-- Nom et Prénom -->
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="">
                                <x-label>Prénom</x-label>
                                <x-input-text type="text" name="first_name" required />
                                @error('first_name')
                                    <div>
                                        <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                            <div class="">
                                <x-label>Nom</x-label>
                                <x-input-text type="text" name="last_name" required />
                                @error('last_name')
                                    <div>
                                        <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Date de naissance -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="">
                                <x-label>Date de naissance</x-label>
                                <x-input-text type="date" name="date_birth" required />
                                @error('date_birth')
                                    <div>
                                        <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                            <div class="">
                                <x-label>Téléphone</x-label>
                                <x-input-text type="number" name="telephone" required />
                                @error('telephone')
                                    <div>
                                        <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <!-- photo -->
                        <div class="">
                            <x-label>Photo</x-label>
                            <x-input-text type="file" name="photo" required />
                            @error('photo')
                                <div>
                                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>

                        <!-- Adresse -->
                        <div class="space-y-4">
                            <div class="">
                                <x-label>Adresse</x-label>
                                <x-input-text type="text" name="address" required placeholder="Rue et numéro" />
                                @error('address')
                                    <div>
                                        <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="">
                                    <x-label>Code postal</x-label>
                                    <x-input-text type="number" name="code_postal" required min="10000"
                                        max="99999" placeholder="54350" />
                                    @error('code_postal')
                                        <div>
                                            <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>
                                <div class="">
                                    <x-label>Ville</x-label>
                                    <x-input-text type="text" name="city" required placeholder="Ville" />
                                    @error('city')
                                        <div>
                                            <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="">
                            <x-label>Adresse e-mail</x-label>
                            <x-input-text type="email" name="email" required />
                            @error('email')
                                <div>
                                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>

                        <!-- Mot de passe -->
                        <div>
                            <x-label>Mot de passe</x-label>
                            <x-input-text type="password" name="password" required />
                            @error('password')
                                <div>
                                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>

                        <!-- Confirmation mot de passe -->
                        <div class="">
                            <x-label>Confirmer le mot de passe</x-label>
                            <x-input-text type="password" name="password_confirmation" required />
                            @error('password_confirmation')
                                <div>
                                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>

                        <!-- Rôle -->
                        <div class="">
                            <x-label>Rôle</x-label>
                            <x-select :options="['Bibliothecaire' => 'Bibliothécaire', 'Client' => 'Client']" name="role"></x-select>
                            @error('role')
                                <div>
                                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <x-primary-button type="submit" class="w-full">
                            Créer un compte
                        </x-primary-button>

                        <p class="text-center text-sm">
                            Déjà inscrit ?
                            <x-link href="{{ route('auth.login.show') }}">
                                Connectez-vous
                            </x-link>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <!-- Footer -->
    <x-partials.footer />
</body>

</html>
