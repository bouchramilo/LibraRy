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

        <section class="bg-light-background dark:bg-dark-background  rounded-lg p-6 mb-8">
            <h2 class="text-xl font-heading mb-6">Informations Personnelles</h2>


            <form class="w-full md:w-full space-y-4" action="{{ route('auth.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="w-full md:w-1/4">
                        <div class="relative">
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo de profil"
                                class="w-full rounded-full aspect-square object-cover border-2 border-light-accent">
                            <input placeholder="📷" type="file" name="photo"
                                value="{{ asset('storage/' . $user->photo) }}"
                                class="absolute bottom-0 right-0 inline-block w-10 h-10  bg-light-primary dark:bg-dark-primary text-white rounded-md hover:transform hover:-translate-y-1 transition-all duration-300">
                            @error('photo')
                                <div>
                                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="w-full flex flex-col gap-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-label>Prénom</x-label>
                                <x-input-text type="text" value="{{ $user->first_name }}" name="first_name" />
                                @error('first_name')
                                    <div>
                                        <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                            <div>
                                <x-label>Nom</x-label>
                                <x-input-text type="text" value="{{ $user->last_name }}" name="last_name" />
                                @error('last_name')
                                    <div>
                                        <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <x-label>Date de naissance</x-label>
                            <x-input-text type="date" value="{{ $user->date_birth }}" name="date_birth" />
                            @error('date_birth')
                                <div>
                                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-label>Email</x-label>
                                <x-input-text type="email" value="{{ $user->email }}" name="email" />
                                @error('email')
                                    <div>
                                        <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                            <div>
                                <x-label>Téléphone</x-label>
                                <x-input-text type="tel" value="{{ $user->telephone }}" name="telephone" />
                                @error('telephone')
                                <div>
                                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                </div>
                            @enderror
                            </div>
                        </div>
                        <div>
                            <x-label>Adresse</x-label>
                            <x-textarea name="address">{{ $user->address }}</x-textarea>
                            @error('address')
                                <div>
                                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-label>Ville</x-label>
                                <x-input-text type="text" value="{{ $user->city }}" name="city" />
                                @error('city')
                                    <div>
                                        <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                            <div>
                                <x-label>Code postal</x-label>
                                <x-input-text type="number" value="{{ $user->code_postal }}" name="code_postal"
                                    min="10000" max="99999" />
                                @error('code_postal')
                                    <div>
                                        <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit"
                            class=" inline-block px-8 py-3 bg-light-primary dark:bg-dark-primary text-white rounded-md hover:transform hover:-translate-y-1 transition-all duration-300">Sauvegarder</button>
                    </div>
                </div>

            </form>
        </section>

        <section class="bg-light-background dark:bg-dark-background rounded-lg p-6 mb-8">
            <h2 class="text-xl font-heading mb-6">Changer le mot de passe</h2>
            <form class="space-y-4 max-w-md">
                <div>
                    <x-label>Ancien mot de passe</x-label>
                    <x-input-text type="password" />
                </div>
                <div>
                    <x-label>Nouveau mot de passe</x-label>
                    <x-input-text type="password" />
                </div>
                <div>
                    <x-label>Confirmer le nouveau mot de passe</x-label>
                    <x-input-text type="password" />
                </div>
                <button type="submit"
                    class=" inline-block px-8 py-3 bg-light-primary dark:bg-dark-primary text-white rounded-md hover:transform hover:-translate-y-1 transition-all duration-300">Modifier</button>
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
            <form class="space-y-4 max-w-md">
                <div>
                    <x-label>Confirmer votre mot de passe</x-label>
                    <x-input-text type="password" class=" border-red-500" />
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
