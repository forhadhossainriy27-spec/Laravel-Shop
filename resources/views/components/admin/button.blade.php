@props([
'type' => 'button',
'variant' => 'primary',
])

@php
$styles = [
'primary' => 'bg-indigo-600 hover:bg-indigo-700 text-white',
'success' => 'bg-emerald-600 hover:bg-emerald-700 text-white',
'danger' => 'bg-red-600 hover:bg-red-700 text-white',
'warning' => 'bg-amber-500 hover:bg-amber-600 text-white',
'secondary' => 'bg-slate-200 hover:bg-slate-300 text-slate-800',
];
@endphp

<button type="{{ $type }}" {{ $attributes->merge([
        'class' => 'inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-medium transition '.$styles[$variant]
    ]) }}>
    {{ $slot }}
</button>