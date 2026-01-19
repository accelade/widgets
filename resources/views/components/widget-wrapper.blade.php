@props([
    'widget' => null,
    'id' => null,
    'columnSpan' => 1,
    'pollingInterval' => null,
    'lazy' => false,
])

@php
    $id = $id ?? ($widget?->getId() ?? uniqid('widget-'));
    $columnSpan = $widget?->getColumnSpan() ?? $columnSpan;
    $pollingInterval = $widget?->getPollingInterval() ?? $pollingInterval;
    $lazy = $widget?->isLazy() ?? $lazy;

    $spanClass = match($columnSpan) {
        'full' => 'col-span-full',
        1 => 'col-span-1',
        2 => 'col-span-2',
        3 => 'col-span-3',
        4 => 'col-span-4',
        6 => 'col-span-6',
        12 => 'col-span-12',
        default => "col-span-{$columnSpan}",
    };
@endphp

<div
    id="{{ $id }}"
    {{ $attributes->class([
        'widget-container',
        $spanClass,
    ]) }}
    @if($pollingInterval)
        data-widget-poll="{{ $pollingInterval }}"
    @endif
    @if($lazy)
        data-widget-lazy="true"
    @endif
>
    {{ $slot }}
</div>
