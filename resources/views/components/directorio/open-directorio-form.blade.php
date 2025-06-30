@props(['title' => 'Agrega Directorio'])

@php
$classes =  'inline-flex items-center px-4 py-2 mt-5 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-blue-500 border border-transparent rounded-md cursor-pointer hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25';
@endphp

<a  wire:click="$dispatch('open-directorio-form')" {{ $attributes->merge(['class' => $classes]) }} >
    {{ $title }}
</a>
