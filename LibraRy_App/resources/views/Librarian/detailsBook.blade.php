@extends('layouts.admin-layout')

@section('title', 'Tableau de bord')
@section('header', 'Tableau de bord')

@section('content')

    <!-- Main Content -->
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-light-bg dark:bg-dark-bg p-6">
        <div class="grid md:grid-cols-2 gap-12 min-h-screen">
            <div class="sm:h-full lg:h-3/4 flex justify-center items-center">
                <img src="../images/img_3.png" alt="Couverture du livre" class="h-full rounded-lg border-none shadow-lg">
            </div>

            <div class="space-y-6">
                <h1 class="text-3xl font-bold font-playfair">Les Misérables</h1>
                <div class="space-y-4">
                    <p class="flex items-center"><span class="w-32 font-semibold">Auteur:</span> {{ $book->author }}</p>
                    <p class="flex items-center"><span class="w-32 font-semibold">Date d'édition:</span> {{ $book->date_edition }}</p>
                    <p class="flex items-center"><span class="w-32 font-semibold">Pages:</span> 1488</p>
                    <p class="flex items-center"><span class="w-32 font-semibold">Genre:</span> Roman historique</p>
                    <p class="flex items-center"><span class="w-32 font-semibold">Langue:</span> Français</p>
                    <p class="flex items-center"><span class="w-32 font-semibold">ISBN:</span> 978-2253096337</p>
                </div>

                <div class="border-t border-b border-light-text/10 dark:border-dark-text/10 py-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xl font-semibold">Prix d'achat: 24,90€</p>
                            <p class="text-sm text-light-text/70 dark:text-dark-text/70">En stock</p>
                        </div> <button
                            class="bg-light-primary dark:bg-dark-primary px-6  rounded-md bg-light-primary dark:bg-dark-primary text-white py-2  hover:opacity-90">
                            Ajouter au panier
                        </button>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xl font-semibold">Prix d'emprunt: 5€/mois</p>
                            <p class="text-sm text-light-text/70 dark:text-dark-text/70">Disponible</p>
                        </div>
                        <button
                            class="border border-light-primary dark:border-dark-primary px-6 py-2  hover:bg-light-primary/10 dark:hover:bg-dark-primary/10 rounded-md border-light-primary dark:border-dark-primary text-light-primary dark:text-dark-primary hover:bg-light-primary/10 dark:hover:bg-dark-primary/10">
                            Emprunter
                        </button>
                    </div>
                </div>


            </div>
        </div>
        <div class="space-y-4">
            <h2 class="text-xl font-bold">Résumé</h2>
            <p class="leading-relaxed">
                Les Misérables est l'un des plus grands romans de la littérature française. À travers le destin
                du forçat Jean Valjean et de sa rédemption, Victor Hugo y décrit la misère du peuple parisien au
                XIXe siècle et dresse un portrait saisissant et critique de la société française. L'histoire
                suit également d'autres personnages mémorables comme Fantine, Cosette, les Thénardier, et
                l'inspecteur Javert.
            </p>
        </div>

    </main>
@endsection
