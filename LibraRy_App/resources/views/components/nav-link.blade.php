@props(['active' => false])

@php
$baseClasses = 'inline-flex items-center px-1 pt-1 border-b-2 leading-5 transition-colors duration-300 focus:outline-none';
$activeClasses = 'border-light-accent dark:border-light-accent text-light-accent dark:text-dark-accent';
$inactiveClasses = 'border-transparent text-light-text dark:text-dark-text hover:text-light-accent dark:hover:text-dark-accent focus:text-light-accent dark:focus:text-dark-accent focus:border-light-accent dark:focus:border-dark-accent';

$classes = $active ? "$baseClasses $activeClasses" : "$baseClasses $inactiveClasses";
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
