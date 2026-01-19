<?php

declare(strict_types=1);

namespace Accelade\Widgets\Components;

use Accelade\Widgets\Widget;
use Closure;

/**
 * Calendar widget for displaying events and schedules.
 */
class CalendarWidget extends Widget
{
    protected string $calendarView = 'dayGridMonth';

    protected string $heading = '';

    protected ?string $description = null;

    protected array $events = [];

    protected array $eventSources = [];

    protected array $resources = [];

    protected ?array $headerToolbar = null;

    protected bool $editable = false;

    protected bool $selectable = false;

    protected bool $nowIndicator = true;

    protected int $firstDay = 0;

    protected string $locale = 'en';

    protected string|int $height = 'auto';

    protected string $eventBackgroundColor = '#3788d8';

    protected string $eventTextColor = '#ffffff';

    /**
     * Available calendar views.
     */
    public const VIEW_DAY_GRID_MONTH = 'dayGridMonth';

    public const VIEW_TIME_GRID_WEEK = 'timeGridWeek';

    public const VIEW_TIME_GRID_DAY = 'timeGridDay';

    public const VIEW_LIST_WEEK = 'listWeek';

    public const VIEW_LIST_MONTH = 'listMonth';

    /**
     * Set the calendar view.
     */
    public function calendarView(string $view): static
    {
        $this->calendarView = $view;

        return $this;
    }

    /**
     * Get the calendar view type.
     */
    public function getCalendarView(): string
    {
        return $this->calendarView;
    }

    /**
     * Set as month grid view.
     */
    public function dayGridMonth(): static
    {
        return $this->calendarView(self::VIEW_DAY_GRID_MONTH);
    }

    /**
     * Set as week time grid view.
     */
    public function timeGridWeek(): static
    {
        return $this->calendarView(self::VIEW_TIME_GRID_WEEK);
    }

    /**
     * Set as day time grid view.
     */
    public function timeGridDay(): static
    {
        return $this->calendarView(self::VIEW_TIME_GRID_DAY);
    }

    /**
     * Set as list week view.
     */
    public function listWeek(): static
    {
        return $this->calendarView(self::VIEW_LIST_WEEK);
    }

    /**
     * Set as list month view.
     */
    public function listMonth(): static
    {
        return $this->calendarView(self::VIEW_LIST_MONTH);
    }

    /**
     * Set the heading.
     */
    public function heading(string $heading): static
    {
        $this->heading = $heading;

        return $this;
    }

    /**
     * Get the heading.
     */
    public function getHeading(): string
    {
        return $this->heading;
    }

    /**
     * Set the description.
     */
    public function description(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the description.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set the events.
     *
     * @param  array<array{title: string, start: string, end?: string, color?: string, ...}>|Closure  $events
     */
    public function events(array|Closure $events): static
    {
        $this->events = $this->evaluate($events);

        return $this;
    }

    /**
     * Get the events.
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    /**
     * Set event sources (URLs for fetching events).
     *
     * @param  array<string|array{url: string, ...}>  $eventSources
     */
    public function eventSources(array $eventSources): static
    {
        $this->eventSources = $eventSources;

        return $this;
    }

    /**
     * Get event sources.
     */
    public function getEventSources(): array
    {
        return $this->eventSources;
    }

    /**
     * Set resources (for timeline/resource views).
     */
    public function resources(array $resources): static
    {
        $this->resources = $resources;

        return $this;
    }

    /**
     * Get resources.
     */
    public function getResources(): array
    {
        return $this->resources;
    }

    /**
     * Set the header toolbar configuration.
     */
    public function headerToolbar(?array $headerToolbar): static
    {
        $this->headerToolbar = $headerToolbar;

        return $this;
    }

    /**
     * Get the header toolbar.
     */
    public function getHeaderToolbar(): ?array
    {
        return $this->headerToolbar;
    }

    /**
     * Make events editable (draggable/resizable).
     */
    public function editable(bool $editable = true): static
    {
        $this->editable = $editable;

        return $this;
    }

    /**
     * Check if editable.
     */
    public function isEditable(): bool
    {
        return $this->editable;
    }

    /**
     * Make calendar selectable (date range selection).
     */
    public function selectable(bool $selectable = true): static
    {
        $this->selectable = $selectable;

        return $this;
    }

    /**
     * Check if selectable.
     */
    public function isSelectable(): bool
    {
        return $this->selectable;
    }

    /**
     * Show/hide the now indicator line.
     */
    public function nowIndicator(bool $nowIndicator = true): static
    {
        $this->nowIndicator = $nowIndicator;

        return $this;
    }

    /**
     * Check if now indicator is shown.
     */
    public function hasNowIndicator(): bool
    {
        return $this->nowIndicator;
    }

    /**
     * Set the first day of week (0 = Sunday, 1 = Monday, etc.).
     */
    public function firstDay(int $firstDay): static
    {
        $this->firstDay = $firstDay;

        return $this;
    }

    /**
     * Get the first day of week.
     */
    public function getFirstDay(): int
    {
        return $this->firstDay;
    }

    /**
     * Set the locale.
     */
    public function locale(string $locale): static
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get the locale.
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * Set the calendar height.
     */
    public function height(string|int $height): static
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get the height.
     */
    public function getHeight(): string|int
    {
        return $this->height;
    }

    /**
     * Set default event background color.
     */
    public function eventBackgroundColor(string $color): static
    {
        $this->eventBackgroundColor = $color;

        return $this;
    }

    /**
     * Get default event background color.
     */
    public function getEventBackgroundColor(): string
    {
        return $this->eventBackgroundColor;
    }

    /**
     * Set default event text color.
     */
    public function eventTextColor(string $color): static
    {
        $this->eventTextColor = $color;

        return $this;
    }

    /**
     * Get default event text color.
     */
    public function getEventTextColor(): string
    {
        return $this->eventTextColor;
    }

    /**
     * Get the full calendar configuration.
     */
    public function getCalendarConfig(): array
    {
        return [
            'view' => $this->calendarView,
            'events' => $this->events,
            'eventSources' => $this->eventSources,
            'resources' => $this->resources,
            'headerToolbar' => $this->headerToolbar,
            'editable' => $this->editable,
            'selectable' => $this->selectable,
            'nowIndicator' => $this->nowIndicator,
            'firstDay' => $this->firstDay,
            'locale' => $this->locale,
            'height' => $this->height,
            'eventBackgroundColor' => $this->eventBackgroundColor,
            'eventTextColor' => $this->eventTextColor,
        ];
    }

    protected function getView(): string
    {
        return 'widgets::components.calendar-widget';
    }

    protected function getViewData(): array
    {
        return [
            'widget' => $this,
            'heading' => $this->getHeading(),
            'description' => $this->getDescription(),
            'calendarConfig' => $this->getCalendarConfig(),
        ];
    }
}
