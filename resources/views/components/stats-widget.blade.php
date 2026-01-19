@props([
    'widget' => null,
    'stats' => [],
    'columns' => null,
])

@php
    $stats = $widget?->getStats() ?? $stats;
    $columns = $widget?->getColumns() ?? $columns ?? 3;
    $id = $widget?->getId() ?? uniqid('stats-widget-');
    $pollingInterval = $widget?->getPollingInterval() ?? null;

    // Filament-style responsive grid classes
    $gridColsClass = match($columns) {
        1 => 'sm:grid-cols-1',
        2 => 'sm:grid-cols-2',
        3 => 'sm:grid-cols-3',
        4 => 'sm:grid-cols-2 xl:grid-cols-4',
        5 => 'sm:grid-cols-2 xl:grid-cols-5',
        6 => 'sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6',
        default => 'sm:grid-cols-3',
    };
@endphp

<div
    id="{{ $id }}"
    {{ $attributes->class(['fi-wi-stats-overview']) }}
    @if($pollingInterval)
        data-widget-poll="{{ $pollingInterval }}"
        wire:poll.{{ $pollingInterval }}
    @endif
>
    <div class="fi-wi-stats-overview-stats-ctn grid grid-cols-1 gap-6 {{ $gridColsClass }}">
        @foreach($stats as $stat)
            <x-widgets::stat :stat="$stat" />
        @endforeach
    </div>
</div>
