@extends('layouts.admin-layout')

@section('title', 'Tableau de bord')
@section('header', 'Tableau de bord')

@section('content')
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-light-bg dark:bg-dark-bg p-4 md:p-6 lg:p-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 xl:gap-12">
            <div class="flex justify-center items-start">
                <img
                    src="{{ $book->photo ? asset('storage/' . $book->photo) : asset('images/default-avatar.jpg') }}"
                    alt="Couverture du livre"
                    class="max-h-[500px] w-auto rounded-lg shadow-lg object-contain hover:scale-105 hover:shadow-2xl hover:shadow-light-secondary"
                >
            </div>

            <div class="space-y-6">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold font-playfair">{{ $book->title }}</h1>

                <div class="space-y-4">
                    <div class="flex flex-wrap items-start">
                        <span class="w-32 font-semibold">Auteur:</span>
                        <span class="flex-1">{{ $book->author }}</span>
                    </div>
                    <div class="flex flex-wrap items-start">
                        <span class="w-32 font-semibold">Date d'édition:</span>
                        <span class="flex-1">{{ $book->date_edition }}</span>
                    </div>
                    <div class="flex flex-wrap items-start">
                        <span class="w-32 font-semibold">Pages:</span>
                        <span class="flex-1">{{ $book->nbr_pages }}</span>
                    </div>
                    <div class="flex flex-wrap items-start">
                        <span class="w-32 font-semibold">Genre:</span>
                        <div class="flex-1 flex flex-wrap gap-2">
                            @foreach ($book->categories as $cate)
                                <span class="bg-accent/10 text-accent rounded-full px-3 py-1 text-sm">
                                    {{ $cate->category }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex flex-wrap items-start">
                        <span class="w-32 font-semibold">Langue:</span>
                        <span class="flex-1">{{ $book->language }}</span>
                    </div>
                    <div class="flex flex-wrap items-start">
                        <span class="w-32 font-semibold">ISBN:</span>
                        <span class="flex-1">{{ $book->isbn }}</span>
                    </div>
                    <div class="flex flex-wrap items-start">
                        <span class="w-32 font-semibold">Nombre d'exemplaire:</span>
                        <span class="flex-1">{{ count($book->exemplaires) }}</span>
                    </div>
                </div>


            </div>
        </div>

        <div class="mt-8 md:mt-12 space-y-4">
            <h2 class="text-xl md:text-2xl font-bold">Résumé</h2>
            <p class="leading-relaxed text-justify">
                {{ $book->resume }}
            </p>
        </div>
    </main>
@endsection
