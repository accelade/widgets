# Accelade Widgets

<p align="center">
<strong>Dashboard Widgets for Laravel. Zero Complexity.</strong>
</p>

<p align="center">
<a href="https://github.com/accelade/widgets/actions/workflows/tests.yml"><img src="https://github.com/accelade/widgets/actions/workflows/tests.yml/badge.svg" alt="Tests"></a>
<a href="https://packagist.org/packages/accelade/widgets"><img src="https://img.shields.io/packagist/v/accelade/widgets" alt="Latest Version"></a>
<a href="https://packagist.org/packages/accelade/widgets"><img src="https://img.shields.io/packagist/dt/accelade/widgets" alt="Total Downloads"></a>
<a href="LICENSE"><img src="https://img.shields.io/badge/license-MIT-blue.svg" alt="License"></a>
</p>

---

Build beautiful, interactive dashboards with minimal code. Accelade Widgets provides a powerful set of dashboard components including stats, charts, tables, and calendars.

```php
use Accelade\Widgets\Components\StatsWidget;
use Accelade\Widgets\Components\Stat;

$widget = StatsWidget::make()
    ->columns(4)
    ->stats([
        Stat::make('Total Users', '12,345')
            ->description('3.5% increase')
            ->icon('heroicon-o-users')
            ->color('primary'),
    ]);
```

**That's it.** Render with `<x-widgets::stats-widget :widget="$widget" />`.

---

## Why Accelade Widgets?

- **Filament-Compatible API** - Familiar syntax if you use Filament
- **Stats Widget** - Display key metrics with icons, descriptions, and trends
- **Chart Widget** - Line, bar, pie, doughnut, and area charts via Chart.js
- **Table Widget** - Display tabular data with sorting and formatting
- **Calendar Widget** - Display events in a calendar view
- **Grid Layout** - Responsive widget arrangement
- **Dark Mode** - Built-in dark mode support
- **Polling** - Auto-refresh widgets at configurable intervals
- **Lazy Loading** - Load widgets on demand with placeholders
- **Lightweight** - Minimal dependencies, maximum performance

---

## Quick Start

```bash
composer require accelade/widgets
```

The service provider will be automatically registered.

### Publish Configuration

```bash
php artisan vendor:publish --tag=widgets-config
```

---

## Features at a Glance

### Stats Widget

```php
use Accelade\Widgets\Components\StatsWidget;
use Accelade\Widgets\Components\Stat;

$widget = StatsWidget::make()
    ->columns(4)
    ->stats([
        Stat::make('Total Users', '12,345')
            ->description('3.5% increase')
            ->descriptionIcon('heroicon-m-arrow-trending-up', 'success')
            ->icon('heroicon-o-users')
            ->color('primary'),

        Stat::make('Revenue', '$45,678')
            ->description('12% increase')
            ->icon('heroicon-o-currency-dollar')
            ->color('success'),

        Stat::make('Orders', '1,234')
            ->description('New this month')
            ->icon('heroicon-o-shopping-cart')
            ->color('warning'),

        Stat::make('Conversion', '3.2%')
            ->description('From last month')
            ->icon('heroicon-o-chart-bar')
            ->color('info'),
    ]);
```

```blade
<x-widgets::stats-widget :widget="$widget" />
```

### Chart Widget

```php
use Accelade\Widgets\Components\ChartWidget;

$chart = ChartWidget::make()
    ->heading('Revenue Overview')
    ->description('Monthly revenue for the past 12 months')
    ->line()
    ->height(350)
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
```

Supported chart types: `line()`, `bar()`, `pie()`, `doughnut()`, `area()`, `radar()`, `polarArea()`.

### Table Widget

```php
use Accelade\Widgets\Components\TableWidget;
use Accelade\Widgets\Components\Column;

$table = TableWidget::make()
    ->heading('Recent Orders')
    ->columns([
        Column::make('id')->label('#')->width('60px'),
        Column::make('customer')->label('Customer')->sortable(),
        Column::make('amount')
            ->label('Amount')
            ->alignRight()
            ->formatStateUsing(fn ($value) => '$' . number_format($value, 2)),
        Column::make('status')
            ->label('Status')
            ->badge()
            ->color(fn ($value) => match ($value) {
                'completed' => 'success',
                'pending' => 'warning',
                'cancelled' => 'danger',
                default => 'gray',
            }),
    ])
    ->records($orders)
    ->striped()
    ->hoverable();
```

### Calendar Widget

```php
use Accelade\Widgets\Components\CalendarWidget;

$calendar = CalendarWidget::make()
    ->heading('Upcoming Events')
    ->events([
        ['title' => 'Team Meeting', 'start' => '2024-01-15', 'color' => '#3b82f6'],
        ['title' => 'Product Launch', 'start' => '2024-01-20', 'end' => '2024-01-22'],
    ]);
```

### Grid Layout

```blade
<x-widgets::grid :columns="12" :gap="6">
    <div class="col-span-8">
        <x-widgets::chart-widget :widget="$chartWidget" />
    </div>
    <div class="col-span-4">
        <x-widgets::stats-widget :widget="$statsWidget" />
    </div>
    <div class="col-span-12">
        <x-widgets::table-widget :widget="$tableWidget" />
    </div>
</x-widgets::grid>
```

### Polling (Auto-Refresh)

```php
$widget = StatsWidget::make()
    ->pollingInterval('30s')  // Refresh every 30 seconds
    ->stats([...]);
```

### Lazy Loading

```php
$widget = ChartWidget::make()
    ->lazy(true, 'Loading chart...')
    ->data([...]);
```

---

## Requirements

- PHP 8.2+
- Laravel 11.x or 12.x

---

## Documentation

| Guide | Description |
|-------|-------------|
| [Getting Started](docs/getting-started.md) | Installation and basic usage |
| [Stats Widget](docs/stats-widget.md) | Display key metrics and statistics |
| [Chart Widget](docs/chart-widget.md) | Charts with Chart.js integration |
| [Table Widget](docs/table-widget.md) | Tabular data display |
| [Calendar Widget](docs/calendar-widget.md) | Calendar view for events |

---

## Accelade Ecosystem

Accelade Widgets is part of the Accelade ecosystem:

| Package | Description |
|---------|-------------|
| **[accelade/accelade](https://github.com/accelade/accelade)** | Core reactive Blade components |
| **[accelade/schemas](https://github.com/accelade/schemas)** | Schema-based layouts |
| **[accelade/forms](https://github.com/accelade/forms)** | Form builder with validation |
| **[accelade/infolists](https://github.com/accelade/infolists)** | Display read-only data |
| **[accelade/tables](https://github.com/accelade/tables)** | Data tables with filtering |
| **[accelade/actions](https://github.com/accelade/actions)** | Action buttons with modals |
| **[accelade/widgets](https://github.com/accelade/widgets)** | Dashboard widgets (this package) |

---

## License

MIT License. See [LICENSE](LICENSE) for details.
