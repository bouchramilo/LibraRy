@extends('layouts.client-layout')

@section('title', 'LibraRy - Catalogue')
@section('header', 'LibraRy - Catalogue')

@section('content')

        <main class="min-h-screen flex items-center justify-center px-4 py-2">
            <x-messages></x-messages>
            <div class="max-w-7xl w-full mx-auto grid md:grid-cols-2 gap-12 items-center">
                <!-- Image Section -->
                <div class="hidden md:block relative " data-aos="zoom-in-left">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-light-primary/20 to-transparent dark:from-dark-primary/20 rounded-2xl">
                    </div>
                    <img src="../images/section2_home.png" alt="Bibliothèque"
                        class="w-full h-[600px] object-cover rounded-2xl shadow-2xl animate-float">
                    <div class="absolute bottom-8 left-8 right-8 p-6 rounded-xl text-light-bg">
                        <h2 class="text-2xl font-bold mb-2">Bienvenue sur BiblioTech</h2>
                        <p class="text-sm opacity-90">Votre bibliothèque numérique personnelle, accessible partout, à tout
                            moment.</p>
                    </div>
                </div>

                <!-- Login  -->
                <div class="w-full max-w-md mx-auto" data-aos="zoom-in-right">

                    <div class="bg-white/5 dark:bg-black/5 p-8 rounded-2xl shadow-2xl dark:shadow-black backdrop-blur-sm">
                        <h2 class="text-3xl font-heading font-bold mb-8 text-center">Connexion</h2>

                        <form class="space-y-6" action="{{ route('auth.login.store') }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="">
                                <x-label>Adresse e-mail</x-label>
                                <x-input-text type="text" name="email" required />
                                @error('email')
                                    <div>
                                        <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>

                            <div class="">
                                <x-label>Mot de passe</x-label>
                                <x-input-text type="password" name="password" required />
                                @error('password')
                                    <div>
                                        <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>

                            <!-- Forgot Password -->
                            {{-- <div class="flex items-center justify-center text-sm">

                                <x-link href="/forgot-password">
                                    Mot de passe oublié ?
                                </x-link>
                            </div> --}}

                            <x-primary-button type="submit" class="w-full">
                                Se connecter
                            </x-primary-button>

                            <p class="text-center text-sm">
                                Pas encore de compte ?

                                <x-link href="{{ route('auth.register.show') }}">
                                    Créez-en un
                                </x-link>
                            </p>
                        </form>
                    </div>

                </div>
            </div>
        </main>

        <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
        <script>
            AOS.init({
                duration: 1000,
                easing: 'ease',
                once: true,
            });
        </script>

@endsection
