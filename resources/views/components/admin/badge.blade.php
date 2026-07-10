@props([
'variant' => 'success',
])

@php
$styles = [
'success' => 'bg-green-100 text-green-700',
'danger' => 'bg-red-100 text-red-700',
'warning' => 'bg-yellow-100 text-yellow-700',
'info' => 'bg-blue-100 text-blue-700',
];
@endphp

<span {{ $attributes->merge([
        'class' => 'inline-flex rounded-full px-3 py-1 text-xs font-semibold '.$styles[$variant]
    ]) }}>
    {{ $slot }}
</span>