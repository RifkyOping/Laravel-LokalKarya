@props([
    'class' => 'h-10 w-auto object-contain',
    'textClass' => 'font-extrabold text-lg sm:text-xl tracking-tight text-gray-900 uppercase'
])

<img src="{{ asset('images/logo.png') }}" alt="Lokalkarya Logo" {{ $attributes->merge(['class' => $class]) }}>
<span class="{{ $textClass }}">LOKALKARYA</span>
