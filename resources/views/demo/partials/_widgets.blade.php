{{-- Widgets Overview Section --}}
@props(['prefix' => 'a'])

@php
    use Accelade\Widgets\Components\Stat;
    use Accelade\Widgets\Components\StatsWidget;
    use Accelade\Widgets\Components\ChartWidget;
    use Accelade\Widgets\Components\TableWidget;
    use Accelade\Widgets\Components\CalendarWidget;
    use Accelade\Widgets\Components\Column;

    // Demo Stats Widget
    $statsWidget = StatsWidget::make()
        ->columns(3)
        ->stats([
            Stat::make('Total Users', '12,345')
                ->description('3.5% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up', 'success')
                ->icon('heroicon-o-users')
                ->color('primary'),

            Stat::make('Revenue', '$45,678')
                ->description('12% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up', 'success')
                ->icon('heroicon-o-currency-dollar')
                ->color('success'),

            Stat::make('Active Sessions', '1,234')
                ->description('5% decrease')
                ->descriptionIcon('heroicon-m-arrow-trending-down', 'danger')
                ->icon('heroicon-o-signal')
                ->color('warning'),
        ]);

    // Demo Chart Widget
    $chartWidget = ChartWidget::make()
        ->heading('Revenue Overview')
        ->description('Monthly revenue trend')
        ->line()
        ->height(250)
        ->data([
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => [12000, 19000, 15000, 25000, 22000, 30000],
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'tension' => 0.4,
                    'fill' => true,
                ],
            ],
        ]);

    // Demo Table Widget
    $tableWidget = TableWidget::make()
        ->heading('Recent Orders')
        ->columns([
            Column::make('id')->label('#')->width('60px'),
            Column::make('customer')->label('Customer'),
            Column::make('amount')
                ->label('Amount')
                ->alignRight()
                ->formatStateUsing(fn ($value) => '$'.number_format($value, 2)),
            Column::make('status')
                ->label('Status')
                ->color(fn ($value) => match ($value) {
                    'completed' => 'success',
                    'pending' => 'warning',
                    default => 'gray',
                }),
        ])
        ->records([
            ['id' => 1, 'customer' => 'John Doe', 'amount' => 125.00, 'status' => 'completed'],
            ['id' => 2, 'customer' => 'Jane Smith', 'amount' => 89.50, 'status' => 'pending'],
            ['id' => 3, 'customer' => 'Bob Wilson', 'amount' => 250.00, 'status' => 'completed'],
        ])
        ->striped()
        ->hoverable();

    // Demo Calendar Widget
    $now = now();
    $calendarWidget = CalendarWidget::make()
        ->heading('Event Calendar')
        ->description('Upcoming events and meetings')
        ->dayGridMonth()
        ->height(400)
        ->events([
            [
                'title' => 'Team Meeting',
                'start' => $now->copy()->addDays(2)->setHour(10)->toIso8601String(),
                'end' => $now->copy()->addDays(2)->setHour(11)->toIso8601String(),
                'color' => '#3b82f6',
            ],
            [
                'title' => 'Product Launch',
                'start' => $now->copy()->addDays(5)->toDateString(),
                'color' => '#22c55e',
            ],
            [
                'title' => 'Conference',
                'start' => $now->copy()->addDays(10)->toDateString(),
                'end' => $now->copy()->addDays(12)->toDateString(),
                'color' => '#f59e0b',
            ],
        ]);
@endphp

<section class="rounded-xl p-6 mb-6 border border-[var(--docs-border)]" style="background: var(--docs-bg-alt);">
    <div class="flex items-center gap-3 mb-2">
        <span class="w-2.5 h-2.5 bg-indigo-500 rounded-full"></span>
        <h3 class="text-lg font-semibold" style="color: var(--docs-text);">Widgets Overview</h3>
    </div>
    <p class="text-sm mb-4" style="color: var(--docs-text-muted);">
        Accelade Widgets provides Filament-style dashboard components for Laravel applications.
    </p>

    <div class="space-y-6 mb-4">
        <!-- Stats Widget Demo -->
        <div class="rounded-xl p-4 border border-indigo-500/30" style="background: rgba(99, 102, 241, 0.1);">
            <h4 class="font-medium mb-3 flex items-center gap-2" style="color: var(--docs-text);">
                <span class="text-xs px-2 py-1 bg-indigo-500/20 text-indigo-500 rounded">📈</span>
                Stats Widget
            </h4>
            <x-widgets::stats-widget :widget="$statsWidget" />
        </div>

        <!-- Chart Widget Demo -->
        <div class="rounded-xl p-4 border border-emerald-500/30" style="background: rgba(16, 185, 129, 0.1);">
            <h4 class="font-medium mb-3 flex items-center gap-2" style="color: var(--docs-text);">
                <span class="text-xs px-2 py-1 bg-emerald-500/20 text-emerald-500 rounded">📉</span>
                Chart Widget
            </h4>
            <x-widgets::chart-widget :widget="$chartWidget" />
        </div>

        <!-- Table Widget Demo -->
        <div class="rounded-xl p-4 border border-amber-500/30" style="background: rgba(245, 158, 11, 0.1);">
            <h4 class="font-medium mb-3 flex items-center gap-2" style="color: var(--docs-text);">
                <span class="text-xs px-2 py-1 bg-amber-500/20 text-amber-500 rounded">📋</span>
                Table Widget
            </h4>
            <x-widgets::table-widget :widget="$tableWidget" />
        </div>

        <!-- Calendar Widget Demo -->
        <div class="rounded-xl p-4 border border-purple-500/30" style="background: rgba(139, 92, 246, 0.1);">
            <h4 class="font-medium mb-3 flex items-center gap-2" style="color: var(--docs-text);">
                <span class="text-xs px-2 py-1 bg-purple-500/20 text-purple-500 rounded">📅</span>
                Calendar Widget
            </h4>
            <x-widgets::calendar-widget :widget="$calendarWidget" />
        </div>
    </div>

    <x-accelade::code-block language="php" filename="widgets-example.php">
use Accelade\Widgets\Components\StatsWidget;
use Accelade\Widgets\Components\Stat;
use Accelade\Widgets\Components\ChartWidget;
use Accelade\Widgets\Components\TableWidget;
use Accelade\Widgets\Components\CalendarWidget;
use Accelade\Widgets\Components\Column;

// Stats Widget
$stats = StatsWidget::make()
    ->columns(3)
    ->stats([
        Stat::make('Total Users', '12,345')
            ->description('3.5% increase')
            ->descriptionIcon('heroicon-m-arrow-trending-up', 'success')
            ->icon('heroicon-o-users')
            ->color('primary'),
    ]);

// Chart Widget
$chart = ChartWidget::make()
    ->heading('Revenue Overview')
    ->line()
    ->data([
        'labels' => ['Jan', 'Feb', 'Mar'],
        'datasets' => [
            ['label' => 'Revenue', 'data' => [12000, 19000, 15000]],
        ],
    ]);

// Table Widget
$table = TableWidget::make()
    ->heading('Recent Orders')
    ->columns([
        Column::make('customer')->label('Customer'),
        Column::make('amount')->formatStateUsing(fn ($v) => '$'.number_format($v, 2)),
    ])
    ->records($orders)
    ->striped();

// Calendar Widget
$calendar = CalendarWidget::make()
    ->heading('Event Calendar')
    ->dayGridMonth()
    ->events([
        ['title' => 'Meeting', 'start' => '2024-01-15T10:00:00', 'color' => '#3b82f6'],
        ['title' => 'Conference', 'start' => '2024-01-20', 'end' => '2024-01-22'],
    ]);
    </x-accelade::code-block>
</section>
