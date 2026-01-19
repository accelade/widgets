@props([
    'columns' => 12,
    'gap' => 6,
])

@php
    $gridClass = "grid-cols-{$columns}";
    $gapClass = "gap-{$gap}";
@endphp

<div {{ $attributes->class([
    'grid',
    $gridClass,
    $gapClass,
]) }}>
    {{ $slot }}
</div>
