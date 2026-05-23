@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-xs text-coffee uppercase tracking-wider mb-1.5 dark:text-cream/80']) }}>
    {{ $value ?? $slot }}
</label>

