@props([
'title',
'value',
'color'=>'indigo'
])

<div class="rounded-2xl bg-white p-6 shadow border">

    <p class="text-slate-500 text-sm">
        {{ $title }}
    </p>

    <h2 class="mt-3 text-3xl font-bold">
        {{ $value }}
    </h2>

</div>