{{-- @props('name') --}}

<label  {{ $attributes->merge(['class' => 'block text-sm font-medium mb-2']) }}>{{ $slot }}</label>
