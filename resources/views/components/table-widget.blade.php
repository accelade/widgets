@props([
    'widget' => null,
    'heading' => '',
    'description' => null,
    'columns' => [],
    'records' => [],
])

@php
    $heading = $widget?->getHeading() ?? $heading;
    $description = $widget?->getDescription() ?? $description;
    $columns = $widget?->getColumns() ?? $columns;
    $records = $widget?->getRecords() ?? collect($records);
    $striped = $widget?->isStriped() ?? false;
    $hoverable = $widget?->isHoverable() ?? true;
    $bordered = $widget?->isBordered() ?? false;
    $compact = $widget?->isCompact() ?? false;
    $id = $widget?->getId() ?? uniqid('table-widget-');
    $pollingInterval = $widget?->getPollingInterval() ?? null;
@endphp

<div
    id="{{ $id }}"
    {{ $attributes->class(['fi-wi-table']) }}
    @if($pollingInterval)
        data-widget-poll="{{ $pollingInterval }}"
        wire:poll.{{ $pollingInterval }}
    @endif
>
    <section class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 overflow-hidden">
        {{-- Header --}}
        @if($heading || $description)
            <header class="fi-section-header flex items-center gap-x-3 px-6 py-4">
                <div class="grid flex-1 gap-y-1">
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
            </header>
        @endif

        {{-- Table --}}
        <div class="fi-ta-content overflow-x-auto">
            <table class="fi-ta-table w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
                <thead class="divide-y divide-gray-200 dark:divide-white/5">
                    <tr class="bg-gray-50 dark:bg-white/5">
                        @foreach($columns as $column)
                            @if(!$column->isHidden())
                                <th
                                    scope="col"
                                    @class([
                                        'fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6',
                                        'text-start' => $column->getAlignment() !== 'right' && $column->getAlignment() !== 'center',
                                        'text-center' => $column->getAlignment() === 'center',
                                        'text-end' => $column->getAlignment() === 'right',
                                    ])
                                    @if($column->getWidth())
                                        style="width: {{ $column->getWidth() }}"
                                    @endif
                                >
                                    <span class="text-sm font-semibold text-gray-950 dark:text-white">
                                        {{ $column->getLabel() }}
                                    </span>
                                </th>
                            @endif
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">
                    @forelse($records as $index => $record)
                        @php
                            $recordUrl = $widget?->getRecordUrl($record);
                        @endphp
                        <tr
                            @class([
                                'fi-ta-row',
                                'bg-gray-50/50 dark:bg-white/2.5' => $striped && $index % 2 === 1,
                                'transition duration-75 hover:bg-gray-50 dark:hover:bg-white/5' => $hoverable,
                                'cursor-pointer' => $recordUrl,
                            ])
                            @if($recordUrl)
                                onclick="window.location.href='{{ $recordUrl }}'"
                            @endif
                        >
                            @foreach($columns as $column)
                                @if(!$column->isHidden())
                                    @php
                                        $state = $column->getState($record);
                                        $color = $column->getColor($record);
                                        $icon = $column->getIcon();
                                    @endphp
                                    <td
                                        @class([
                                            'fi-ta-cell px-3 sm:first-of-type:ps-6 sm:last-of-type:pe-6',
                                            'py-4' => !$compact,
                                            'py-2' => $compact,
                                            'text-start' => $column->getAlignment() !== 'right' && $column->getAlignment() !== 'center',
                                            'text-center' => $column->getAlignment() === 'center',
                                            'text-end' => $column->getAlignment() === 'right',
                                        ])
                                    >
                                        <div @class([
                                            'fi-ta-col-wrp flex items-center gap-1.5',
                                            'justify-end' => $column->getAlignment() === 'right',
                                            'justify-center' => $column->getAlignment() === 'center',
                                        ])>
                                            @if($icon && $column->getIconPosition() === 'before')
                                                <x-dynamic-component :component="$icon" class="h-5 w-5 text-gray-400" />
                                            @endif

                                            @if($color && in_array($color, ['success', 'warning', 'danger', 'info', 'primary', 'gray']))
                                                <span @class([
                                                    'fi-badge flex items-center justify-center gap-x-1 rounded-md text-xs font-medium ring-1 ring-inset px-2 min-w-[theme(spacing.6)] py-1',
                                                    'bg-emerald-50 text-emerald-600 ring-emerald-600/10 dark:bg-emerald-400/10 dark:text-emerald-400 dark:ring-emerald-400/30' => $color === 'success',
                                                    'bg-amber-50 text-amber-600 ring-amber-600/10 dark:bg-amber-400/10 dark:text-amber-400 dark:ring-amber-400/30' => $color === 'warning',
                                                    'bg-rose-50 text-rose-600 ring-rose-600/10 dark:bg-rose-400/10 dark:text-rose-400 dark:ring-rose-400/30' => $color === 'danger',
                                                    'bg-sky-50 text-sky-600 ring-sky-600/10 dark:bg-sky-400/10 dark:text-sky-400 dark:ring-sky-400/30' => $color === 'info',
                                                    'bg-primary-50 text-primary-600 ring-primary-600/10 dark:bg-primary-400/10 dark:text-primary-400 dark:ring-primary-400/30' => $color === 'primary',
                                                    'bg-gray-50 text-gray-600 ring-gray-600/10 dark:bg-gray-400/10 dark:text-gray-400 dark:ring-gray-400/20' => $color === 'gray',
                                                ])>
                                                    {{ $state }}
                                                </span>
                                            @else
                                                <span class="text-sm text-gray-950 dark:text-white">
                                                    {{ $state }}
                                                </span>
                                            @endif

                                            @if($icon && $column->getIconPosition() === 'after')
                                                <x-dynamic-component :component="$icon" class="h-5 w-5 text-gray-400" />
                                            @endif
                                        </div>
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) }}" class="fi-ta-empty-state-cell px-6 py-12">
                                <div class="fi-ta-empty-state mx-auto grid max-w-lg justify-items-center text-center">
                                    <div class="fi-ta-empty-state-icon-ctn mb-4 rounded-full bg-gray-100 p-3 dark:bg-gray-500/20">
                                        @if($widget?->getEmptyStateIcon())
                                            <x-dynamic-component
                                                :component="$widget->getEmptyStateIcon()"
                                                class="fi-ta-empty-state-icon h-6 w-6 text-gray-500 dark:text-gray-400"
                                            />
                                        @else
                                            <svg class="fi-ta-empty-state-icon h-6 w-6 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        @endif
                                    </div>
                                    <h4 class="fi-ta-empty-state-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                                        {{ $widget?->getEmptyStateHeading() ?? 'No records' }}
                                    </h4>
                                    @if($widget?->getEmptyStateDescription())
                                        <p class="fi-ta-empty-state-description mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $widget->getEmptyStateDescription() }}
                                        </p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
