# Getting Started with Accelade Widgets

Accelade Widgets provides a powerful set of dashboard components for Laravel applications. Build beautiful, interactive dashboards with minimal code.

## Installation

Install the package via Composer:

```bash
composer require accelade/widgets
```

The service provider will be automatically registered.

## Publishing Assets

Publish the configuration file:

```bash
php artisan vendor:publish --tag=widgets-config
```

Publish the views for customization:

```bash
php artisan vendor:publish --tag=widgets-views
```

## Quick Start

### Stats Widget

Display key metrics with the StatsWidget:

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
            ->descriptionIcon('heroicon-m-arrow-trending-up', 'success')
            ->icon('heroicon-o-currency-dollar')
            ->color('success'),
    ]);
```

In your Blade template:

```blade
<x-widgets::stats-widget :widget="$widget" />
```

### Chart Widget

Display charts using Chart.js:

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

### Table Widget

Display tabular data:

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

## Grid Layout

Arrange widgets in a responsive grid:

```blade
<x-widgets::grid :columns="12" :gap="6">
    <div class="col-span-8">
        <x-widgets::chart-widget :widget="$chartWidget" />
    </div>
    <div class="col-span-4">
        <x-widgets::stats-widget :widget="$statsWidget" />
    </div>
</x-widgets::grid>
```

## Features

- **Filament-compatible API** - Familiar syntax if you use Filament
- **Dark mode support** - Built-in dark mode styling
- **Responsive design** - Works on all screen sizes
- **Chart.js integration** - Powerful charting capabilities
- **Polling/auto-refresh** - Keep data up to date
- **Lazy loading** - Load widgets on demand
- **Grid layout system** - Flexible widget arrangement
