# Calendar Widget

The Calendar Widget displays events and schedules using FullCalendar, supporting multiple views and interactive features.

## Basic Usage

```php
use Accelade\Widgets\Components\CalendarWidget;

$widget = CalendarWidget::make()
    ->heading('Event Calendar')
    ->dayGridMonth()
    ->events([
        [
            'title' => 'Team Meeting',
            'start' => '2024-01-15T10:00:00',
            'end' => '2024-01-15T11:00:00',
            'color' => '#3b82f6',
        ],
        [
            'title' => 'Conference',
            'start' => '2024-01-20',
            'end' => '2024-01-22',
            'color' => '#22c55e',
        ],
    ]);
```

```blade
<x-widgets::calendar-widget :widget="$widget" />
```

## Calendar Views

### Month Grid View

```php
CalendarWidget::make()->dayGridMonth();
```

### Week Time Grid View

```php
CalendarWidget::make()->timeGridWeek();
```

### Day Time Grid View

```php
CalendarWidget::make()->timeGridDay();
```

### List Week View

```php
CalendarWidget::make()->listWeek();
```

### List Month View

```php
CalendarWidget::make()->listMonth();
```

## Configuration

### Heading & Description

```php
CalendarWidget::make()
    ->heading('Event Calendar')
    ->description('View and manage your scheduled events');
```

### Height

```php
CalendarWidget::make()->height(500); // Height in pixels or 'auto'
```

### Interactivity

Enable event dragging and date selection:

```php
CalendarWidget::make()
    ->editable()    // Allow drag and resize of events
    ->selectable(); // Allow date range selection
```

### First Day of Week

```php
CalendarWidget::make()->firstDay(1); // 0 = Sunday, 1 = Monday
```

### Locale

```php
CalendarWidget::make()->locale('fr'); // French locale
```

### Now Indicator

Show the current time indicator in time-based views:

```php
CalendarWidget::make()->nowIndicator(true);
```

### Custom Header Toolbar

```php
CalendarWidget::make()
    ->headerToolbar([
        'start' => 'prev,next today',
        'center' => 'title',
        'end' => 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
    ]);
```

### Event Colors

Set default event colors:

```php
CalendarWidget::make()
    ->eventBackgroundColor('#3788d8')
    ->eventTextColor('#ffffff');
```

## Event Format

Events follow FullCalendar format:

```php
[
    [
        'title' => 'Team Meeting',
        'start' => '2024-01-15T10:00:00', // ISO 8601 format
        'end' => '2024-01-15T11:00:00',
        'color' => '#3b82f6',
        'allDay' => false,
    ],
    [
        'title' => 'Holiday',
        'start' => '2024-01-20',
        'end' => '2024-01-21', // End is exclusive for all-day events
        'color' => '#22c55e',
        'allDay' => true,
    ],
]
```

## Event Sources

Load events from URLs:

```php
CalendarWidget::make()
    ->eventSources([
        '/api/events',
        [
            'url' => '/api/meetings',
            'color' => '#3b82f6',
        ],
    ]);
```

## Dynamic Events

Use closures for dynamic event data:

```php
CalendarWidget::make()
    ->events(function () {
        return Event::query()
            ->whereMonth('start_date', now()->month)
            ->get()
            ->map(fn ($event) => [
                'title' => $event->title,
                'start' => $event->start_date->toIso8601String(),
                'end' => $event->end_date->toIso8601String(),
                'color' => $event->color,
            ])
            ->toArray();
    });
```

## Resources

For resource/timeline views:

```php
CalendarWidget::make()
    ->resources([
        ['id' => 'room1', 'title' => 'Conference Room A'],
        ['id' => 'room2', 'title' => 'Conference Room B'],
        ['id' => 'room3', 'title' => 'Meeting Room'],
    ]);
```

## Full Example

```php
use Accelade\Widgets\Components\CalendarWidget;

$widget = CalendarWidget::make()
    ->heading('Team Schedule')
    ->description('View all team events and meetings')
    ->dayGridMonth()
    ->height(600)
    ->editable()
    ->selectable()
    ->nowIndicator()
    ->firstDay(1) // Start week on Monday
    ->locale('en')
    ->headerToolbar([
        'start' => 'prev,next today',
        'center' => 'title',
        'end' => 'dayGridMonth,timeGridWeek,listWeek',
    ])
    ->events([
        [
            'title' => 'Sprint Planning',
            'start' => now()->startOfWeek()->addDays(1)->setHour(9)->toIso8601String(),
            'end' => now()->startOfWeek()->addDays(1)->setHour(11)->toIso8601String(),
            'color' => '#3b82f6',
        ],
        [
            'title' => 'Team Standup',
            'start' => now()->startOfWeek()->addDays(2)->setHour(10)->toIso8601String(),
            'end' => now()->startOfWeek()->addDays(2)->setHour(10)->addMinutes(30)->toIso8601String(),
            'color' => '#22c55e',
        ],
        [
            'title' => 'Product Demo',
            'start' => now()->startOfWeek()->addDays(4)->toDateString(),
            'color' => '#f59e0b',
            'allDay' => true,
        ],
    ]);
```

## API Reference

| Method | Description |
|--------|-------------|
| `heading(string)` | Set the widget heading |
| `description(string)` | Set the widget description |
| `view(string)` | Set the calendar view |
| `dayGridMonth()` | Month grid view |
| `timeGridWeek()` | Week time grid view |
| `timeGridDay()` | Day time grid view |
| `listWeek()` | Weekly list view |
| `listMonth()` | Monthly list view |
| `events(array\|Closure)` | Set calendar events |
| `eventSources(array)` | Set event source URLs |
| `resources(array)` | Set resources for timeline views |
| `headerToolbar(array)` | Configure header toolbar |
| `height(int\|string)` | Set calendar height |
| `editable(bool)` | Enable event drag/resize |
| `selectable(bool)` | Enable date range selection |
| `nowIndicator(bool)` | Show current time indicator |
| `firstDay(int)` | Set first day of week (0-6) |
| `locale(string)` | Set calendar locale |
| `eventBackgroundColor(string)` | Default event background color |
| `eventTextColor(string)` | Default event text color |
