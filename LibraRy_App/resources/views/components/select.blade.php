{{-- @props(['options'])

<select
    {{ $attributes->class(['w-full px-4 py-2 rounded-lg border border-light-primary/20 dark:border-dark-primary/20 bg-white/5 dark:bg-black/5 focus:ring-2  focus:ring-light-accent dark:focus:ring-dark-accent focus:outline-none focus:border-b-0 transition-all duration-300']) }}>

    <option value="" >-- choisissez une options --</option>
    @foreach ($options as $key => $value)
        <option value="{{ $key }}">{{ $value }}</option>
    @endforeach

</select> --}}


@props([
    'options' => [],
    'selected' => null,
    'placeholder' => '-- choisissez une option --'
])

<select
    {{ $attributes->merge([
        'class' => 'w-full px-4 py-2 rounded-lg border border-light-primary/20 dark:border-dark-primary/20 bg-white/5 dark:bg-black/5 focus:ring-2 focus:ring-light-accent dark:focus:ring-dark-accent focus:outline-none focus:border-b-0 transition-all duration-300'
    ]) }}
>
    @if($placeholder)
        <option value="" disabled {{ is_null($selected) ? 'selected' : '' }}>
            {{ $placeholder }}
        </option>
    @endif

    @foreach ($options as $key => $value)
        <option class=" bg-white dark:bg-dark-bg shadow-lg border border-light-accent dark:border-dark-accent "
            value="{{ $key }}"
            {{ $selected == $key ? 'selected' : '' }}
        >
            {{ $value }}
        </option>
    @endforeach
</select>
