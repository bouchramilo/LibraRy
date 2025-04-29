@props(['active' => false, 'href'])

@php
$classes = $active
    ? 'flex items-center space-x-2 px-4 py-2 rounded-lg bg-light-primary text-white dark:bg-dark-primary dark:text-white'
    : 'flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-light-primary/20 dark:hover:bg-dark-primary/20 transition-colors';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
