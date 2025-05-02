@extends('layouts.admin-layout')

@section('title', 'Tableau de bord')
@section('header', 'Tableau de bord')

@section('content')

    <section
        class="py-20 px-4 min-h-[700px] min-w-screen bg-light-primary/5 dark:bg-dark-primary/5 flex flex-col justify-center items-center gap-16">
        <p>404 - Not Found</p>
        <a href="/"><x-primary-button>Allez au Acceuil</x-primary-button></a>
    </section>

@endsection
