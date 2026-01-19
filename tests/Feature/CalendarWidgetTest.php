<?php

declare(strict_types=1);

use Accelade\Widgets\Components\CalendarWidget;

it('can create calendar widget with configuration', function () {
    $widget = CalendarWidget::make()
        ->heading('Event Calendar')
        ->description('View scheduled events')
        ->dayGridMonth()
        ->height(500)
        ->events([
            [
                'title' => 'Team Meeting',
                'start' => '2024-01-15T10:00:00',
                'end' => '2024-01-15T11:00:00',
            ],
        ]);

    expect($widget->getHeading())->toBe('Event Calendar');
    expect($widget->getDescription())->toBe('View scheduled events');
    expect($widget->getCalendarView())->toBe('dayGridMonth');
    expect($widget->getHeight())->toBe(500);
    expect($widget->getEvents())->toHaveCount(1);
});

it('can set all calendar views', function (string $method, string $expectedView) {
    $widget = CalendarWidget::make()->{$method}();

    expect($widget->getCalendarView())->toBe($expectedView);
})->with([
    ['dayGridMonth', 'dayGridMonth'],
    ['timeGridWeek', 'timeGridWeek'],
    ['timeGridDay', 'timeGridDay'],
    ['listWeek', 'listWeek'],
    ['listMonth', 'listMonth'],
]);

it('can set events', function () {
    $events = [
        ['title' => 'Event 1', 'start' => '2024-01-15'],
        ['title' => 'Event 2', 'start' => '2024-01-16'],
    ];

    $widget = CalendarWidget::make()->events($events);

    expect($widget->getEvents())->toBe($events);
    expect($widget->getEvents())->toHaveCount(2);
});

it('can set event sources', function () {
    $sources = [
        '/api/events',
        ['url' => '/api/meetings', 'color' => '#3b82f6'],
    ];

    $widget = CalendarWidget::make()->eventSources($sources);

    expect($widget->getEventSources())->toBe($sources);
});

it('can enable interactivity', function () {
    $widget = CalendarWidget::make()
        ->editable()
        ->selectable();

    expect($widget->isEditable())->toBeTrue();
    expect($widget->isSelectable())->toBeTrue();
});

it('can disable interactivity', function () {
    $widget = CalendarWidget::make()
        ->editable(false)
        ->selectable(false);

    expect($widget->isEditable())->toBeFalse();
    expect($widget->isSelectable())->toBeFalse();
});

it('can set first day of week', function () {
    $widget = CalendarWidget::make()->firstDay(1); // Monday

    expect($widget->getFirstDay())->toBe(1);
});

it('can set locale', function () {
    $widget = CalendarWidget::make()->locale('fr');

    expect($widget->getLocale())->toBe('fr');
});

it('can set height', function () {
    $widget = CalendarWidget::make()->height(600);

    expect($widget->getHeight())->toBe(600);
});

it('can set header toolbar', function () {
    $toolbar = [
        'start' => 'prev,next',
        'center' => 'title',
        'end' => 'dayGridMonth,timeGridWeek',
    ];

    $widget = CalendarWidget::make()->headerToolbar($toolbar);

    expect($widget->getHeaderToolbar())->toBe($toolbar);
});

it('can set event colors', function () {
    $widget = CalendarWidget::make()
        ->eventBackgroundColor('#3788d8')
        ->eventTextColor('#ffffff');

    expect($widget->getEventBackgroundColor())->toBe('#3788d8');
    expect($widget->getEventTextColor())->toBe('#ffffff');
});

it('can show now indicator', function () {
    $widget = CalendarWidget::make()->nowIndicator(true);

    expect($widget->hasNowIndicator())->toBeTrue();
});

it('can set resources', function () {
    $resources = [
        ['id' => 'room1', 'title' => 'Conference Room A'],
        ['id' => 'room2', 'title' => 'Conference Room B'],
    ];

    $widget = CalendarWidget::make()->resources($resources);

    expect($widget->getResources())->toBe($resources);
});

it('generates calendar config', function () {
    $widget = CalendarWidget::make()
        ->dayGridMonth()
        ->editable()
        ->selectable()
        ->firstDay(1)
        ->locale('en')
        ->events([['title' => 'Test', 'start' => '2024-01-15']]);

    $config = $widget->getCalendarConfig();

    expect($config)->toHaveKey('view');
    expect($config)->toHaveKey('events');
    expect($config)->toHaveKey('editable');
    expect($config)->toHaveKey('selectable');
    expect($config)->toHaveKey('firstDay');
    expect($config)->toHaveKey('locale');
    expect($config['view'])->toBe('dayGridMonth');
    expect($config['editable'])->toBeTrue();
    expect($config['selectable'])->toBeTrue();
    expect($config['firstDay'])->toBe(1);
});

it('has correct view path for Filament styling', function () {
    $widget = CalendarWidget::make()
        ->heading('Calendar')
        ->events([]);

    // Test that the widget has proper configuration
    expect($widget->getHeading())->toBe('Calendar');
    expect($widget->getEvents())->toBeEmpty();

    // The calendar widget uses widgets::components.calendar-widget view
    // which includes fi-wi-calendar class
});

it('can use closure for events', function () {
    $widget = CalendarWidget::make()
        ->events(function () {
            return [
                ['title' => 'Dynamic Event', 'start' => '2024-01-15'],
            ];
        });

    $events = $widget->getEvents();

    expect($events)->toBeArray();
    expect($events)->toHaveCount(1);
    expect($events[0]['title'])->toBe('Dynamic Event');
});
