<div {{ $attributes->merge([
    'class' => 'bg-white rounded-2xl border border-slate-200 shadow-sm'
]) }}>
    {{ $slot }}
</div>