@props([
    'widget' => null,
    'heading' => '',
    'description' => null,
    'chartConfig' => [],
    'height' => 300,
    'filters' => [],
    'activeFilter' => null,
])

@php
    $heading = $widget?->getHeading() ?? $heading;
    $description = $widget?->getDescription() ?? $description;
    $chartConfig = $widget?->getChartConfig() ?? $chartConfig;
    $height = $widget?->getHeight() ?? $height;
    $filters = $widget?->getFilters() ?? $filters;
    $activeFilter = $widget?->getActiveFilter() ?? $activeFilter;
    $id = $widget?->getId() ?? uniqid('chart-widget-');
    $chartId = 'chart-' . $id;
    $pollingInterval = $widget?->getPollingInterval() ?? null;

    // Extract chart type and data from config for Accelade chart component
    $chartType = $chartConfig['type'] ?? 'line';
    $chartData = $chartConfig['data'] ?? [];
    $chartOptions = $chartConfig['options'] ?? [];
    $chartLabels = $chartData['labels'] ?? [];
    $chartDatasets = $chartData['datasets'] ?? [];
@endphp

<div
    id="{{ $id }}"
    {{ $attributes->class(['fi-wi-chart']) }}
    @if($pollingInterval)
        data-widget-poll="{{ $pollingInterval }}"
        wire:poll.{{ $pollingInterval }}
    @endif
>
    <section class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        {{-- Header --}}
        @if($heading || $description || count($filters) > 0)
            <header class="fi-section-header flex flex-col gap-3 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="grid gap-y-1">
                    @if($heading)
                        <h3 class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                            {{ $heading }}
                        </h3>
                    @endif
                    @if($description)
                        <p class="fi-section-header-description text-sm text-gray-500 dark:text-gray-400">
                            {{ $description }}
                        </p>
                    @endif
                </div>

                {{-- Filters (Filament style tabs) --}}
                @if(count($filters) > 0)
                    <div class="flex items-center gap-x-1">
                        @foreach($filters as $key => $label)
                            <button
                                type="button"
                                data-chart-filter="{{ $key }}"
                                @class([
                                    'fi-tabs-item flex items-center gap-x-2 rounded-lg px-3 py-2 text-sm font-medium outline-none transition duration-75',
                                    'fi-active bg-gray-50 dark:bg-white/5 text-primary-600 dark:text-primary-400' => $key === $activeFilter,
                                    'text-gray-500 hover:bg-gray-50 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-200' => $key !== $activeFilter,
                                ])
                            >
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>
                @endif
            </header>
        @endif

        {{-- Chart Content --}}
        <div class="fi-section-content p-6 @if($heading || $description || count($filters) > 0) pt-0 @endif">
            <x-accelade::chart
                :type="$chartType"
                :labels="$chartLabels"
                :datasets="$chartDatasets"
                :options="$chartOptions"
                :height="$height . 'px'"
                :id="$chartId"
            />
        </div>
    </section>
</div>
