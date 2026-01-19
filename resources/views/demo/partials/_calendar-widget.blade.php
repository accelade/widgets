{{-- Calendar Widget Section --}}
@props(['prefix' => 'a'])

@php
    use Accelade\Widgets\Components\CalendarWidget;

    // Generate sample events for current month
    $now = now();
    $events = [
        [
            'title' => 'Team Meeting',
            'start' => $now->copy()->startOfMonth()->addDays(2)->setHour(10)->toIso8601String(),
            'end' => $now->copy()->startOfMonth()->addDays(2)->setHour(11)->toIso8601String(),
            'color' => '#3b82f6',
        ],
        [
            'title' => 'Product Launch',
            'start' => $now->copy()->startOfMonth()->addDays(5)->toDateString(),
            'end' => $now->copy()->startOfMonth()->addDays(5)->toDateString(),
            'color' => '#22c55e',
        ],
        [
            'title' => 'Conference',
            'start' => $now->copy()->startOfMonth()->addDays(10)->toDateString(),
            'end' => $now->copy()->startOfMonth()->addDays(12)->toDateString(),
            'color' => '#f59e0b',
        ],
        [
            'title' => 'Sprint Review',
            'start' => $now->copy()->startOfMonth()->addDays(15)->setHour(14)->toIso8601String(),
            'end' => $now->copy()->startOfMonth()->addDays(15)->setHour(16)->toIso8601String(),
            'color' => '#8b5cf6',
        ],
        [
            'title' => 'Client Call',
            'start' => $now->copy()->startOfMonth()->addDays(18)->setHour(9)->toIso8601String(),
            'end' => $now->copy()->startOfMonth()->addDays(18)->setHour(10)->toIso8601String(),
            'color' => '#ef4444',
        ],
        [
            'title' => 'Workshop',
            'start' => $now->copy()->startOfMonth()->addDays(22)->toDateString(),
            'end' => $now->copy()->startOfMonth()->addDays(23)->toDateString(),
            'color' => '#06b6d4',
        ],
    ];

    // Basic Calendar Widget
    $basicCalendar = CalendarWidget::make()
        ->heading('Event Calendar')
        ->description('View and manage your scheduled events')
        ->dayGridMonth()
        ->events($events)
        ->height(500);

    // Week View Calendar
    $weekCalendar = CalendarWidget::make()
        ->heading('Weekly Schedule')
        ->description('Time-based view of your week')
        ->timeGridWeek()
        ->events($events)
        ->height(450)
        ->nowIndicator();

    // List View Calendar
    $listCalendar = CalendarWidget::make()
        ->heading('Upcoming Events')
        ->description('List view of scheduled events')
        ->listWeek()
        ->events($events)
        ->height(300);

    // Interactive Calendar (editable & selectable)
    $interactiveCalendar = CalendarWidget::make()
        ->heading('Interactive Calendar')
        ->description('Drag events and select date ranges')
        ->dayGridMonth()
        ->events($events)
        ->editable()
        ->selectable()
        ->height(450);
@endphp

<section class="rounded-xl p-6 mb-6 border border-[var(--docs-border)]" style="background: var(--docs-bg-alt);">
    <div class="flex items-center gap-3 mb-2">
        <span class="w-2.5 h-2.5 bg-purple-500 rounded-full"></span>
        <h3 class="text-lg font-semibold" style="color: var(--docs-text);">Calendar Widget</h3>
    </div>
    <p class="text-sm mb-4" style="color: var(--docs-text-muted);">
        Display events and schedules using FullCalendar with support for multiple views, event management, and interactivity.
    </p>

    <div class="space-y-6 mb-4">
        <!-- Month Grid Calendar -->
        <div class="rounded-xl p-4 border border-indigo-500/30" style="background: rgba(99, 102, 241, 0.1);">
            <h4 class="font-medium mb-3 flex items-center gap-2" style="color: var(--docs-text);">
                <span class="text-xs px-2 py-1 bg-indigo-500/20 text-indigo-500 rounded">Month</span>
                Month Grid View
            </h4>
            <x-widgets::calendar-widget :widget="$basicCalendar" />
        </div>

        <!-- Week Time Grid -->
        <div class="rounded-xl p-4 border border-emerald-500/30" style="background: rgba(16, 185, 129, 0.1);">
            <h4 class="font-medium mb-3 flex items-center gap-2" style="color: var(--docs-text);">
                <span class="text-xs px-2 py-1 bg-emerald-500/20 text-emerald-500 rounded">Week</span>
                Time Grid Week View
            </h4>
            <x-widgets::calendar-widget :widget="$weekCalendar" />
        </div>

        <!-- List View -->
        <div class="rounded-xl p-4 border border-amber-500/30" style="background: rgba(245, 158, 11, 0.1);">
            <h4 class="font-medium mb-3 flex items-center gap-2" style="color: var(--docs-text);">
                <span class="text-xs px-2 py-1 bg-amber-500/20 text-amber-500 rounded">List</span>
                List View
            </h4>
            <x-widgets::calendar-widget :widget="$listCalendar" />
        </div>

        <!-- Interactive Calendar -->
        <div class="rounded-xl p-4 border border-purple-500/30" style="background: rgba(139, 92, 246, 0.1);">
            <h4 class="font-medium mb-3 flex items-center gap-2" style="color: var(--docs-text);">
                <span class="text-xs px-2 py-1 bg-purple-500/20 text-purple-500 rounded">Interactive</span>
                Editable & Selectable
            </h4>
            <x-widgets::calendar-widget :widget="$interactiveCalendar" />
        </div>
    </div>

    <x-accelade::code-block language="php" filename="calendar-widget-example.php">
use Accelade\Widgets\Components\CalendarWidget;

// Basic Calendar Widget
$calendar = CalendarWidget::make()
    ->heading('Event Calendar')
    ->description('View and manage your scheduled events')
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
    ])
    ->height(500);

// Week View Calendar
$weekCalendar = CalendarWidget::make()
    ->heading('Weekly Schedule')
    ->timeGridWeek()
    ->events($events)
    ->nowIndicator();

// Interactive Calendar
$interactiveCalendar = CalendarWidget::make()
    ->heading('Interactive Calendar')
    ->dayGridMonth()
    ->events($events)
    ->editable()      // Enable drag and resize
    ->selectable();   // Enable date range selection

// Available views:
// ->dayGridMonth()   - Month grid view
// ->timeGridWeek()   - Week time grid view
// ->timeGridDay()    - Day time grid view
// ->listWeek()       - Weekly list view
// ->listMonth()      - Monthly list view
    </x-accelade::code-block>
</section>
