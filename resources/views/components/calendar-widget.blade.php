@props([
    'widget' => null,
    'heading' => '',
    'description' => null,
    'view' => 'dayGridMonth',
    'events' => [],
    'eventSources' => [],
    'resources' => [],
    'headerToolbar' => null,
    'editable' => false,
    'selectable' => false,
    'nowIndicator' => true,
    'firstDay' => 0,
    'locale' => 'en',
    'height' => 'auto',
    'eventBackgroundColor' => '#3788d8',
    'eventTextColor' => '#ffffff',
])

@php
    $heading = $widget?->getHeading() ?? $heading;
    $description = $widget?->getDescription() ?? $description;
    $view = $widget?->getCalendarView() ?? $view;
    $events = $widget?->getEvents() ?? $events;
    $eventSources = $widget?->getEventSources() ?? $eventSources;
    $resources = $widget?->getResources() ?? $resources;
    $headerToolbar = $widget?->getHeaderToolbar() ?? $headerToolbar;
    $editable = $widget?->isEditable() ?? $editable;
    $selectable = $widget?->isSelectable() ?? $selectable;
    $nowIndicator = $widget?->hasNowIndicator() ?? $nowIndicator;
    $firstDay = $widget?->getFirstDay() ?? $firstDay;
    $locale = $widget?->getLocale() ?? $locale;
    $height = $widget?->getHeight() ?? $height;
    $eventBackgroundColor = $widget?->getEventBackgroundColor() ?? $eventBackgroundColor;
    $eventTextColor = $widget?->getEventTextColor() ?? $eventTextColor;
    $id = $widget?->getId() ?? uniqid('calendar-widget-');
    $pollingInterval = $widget?->getPollingInterval() ?? null;
@endphp

<div
    id="{{ $id }}"
    {{ $attributes->class(['fi-wi-calendar']) }}
    @if($pollingInterval)
        data-widget-poll="{{ $pollingInterval }}"
        wire:poll.{{ $pollingInterval }}
    @endif
>
    <section class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
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

        {{-- Calendar Content --}}
        <div class="fi-section-content p-6 @if($heading || $description) pt-0 @endif">
            <x-accelade::calendar
                :view="$view"
                :events="$events"
                :eventSources="$eventSources"
                :resources="$resources"
                :headerToolbar="$headerToolbar"
                :editable="$editable"
                :selectable="$selectable"
                :nowIndicator="$nowIndicator"
                :firstDay="$firstDay"
                :locale="$locale"
                :height="$height"
                :eventBackgroundColor="$eventBackgroundColor"
                :eventTextColor="$eventTextColor"
            />
        </div>
    </section>
</div>
