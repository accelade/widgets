# Stats Widget

The Stats Widget displays key metrics and statistics in a card-based layout, similar to Filament's StatsOverviewWidget.

## Basic Usage

```php
use Accelade\Widgets\Components\StatsWidget;
use Accelade\Widgets\Components\Stat;

$widget = StatsWidget::make()
    ->columns(4)
    ->stats([
        Stat::make('Total Users', '12,345'),
        Stat::make('Revenue', '$45,678'),
        Stat::make('Orders', '1,234'),
        Stat::make('Conversion', '3.2%'),
    ]);
```

```blade
<x-widgets::stats-widget :widget="$widget" />
```

## Stat Configuration

### Description

Add a description below the value:

```php
Stat::make('Total Users', '12,345')
    ->description('3.5% increase from last month');
```

### Description Icon

Add an icon next to the description with a color:

```php
Stat::make('Total Users', '12,345')
    ->description('3.5% increase')
    ->descriptionIcon('heroicon-m-arrow-trending-up', 'success');
```

Available colors: `success`, `warning`, `danger`, `info`, `primary`.

### Main Icon

Display a large icon on the stat card:

```php
Stat::make('Total Users', '12,345')
    ->icon('heroicon-o-users')
    ->icon('heroicon-o-users', 'primary'); // With color
```

### Color Theme

Set the card's color theme:

```php
Stat::make('Revenue', '$45,678')
    ->color('success');
```

### Mini Chart

Display a sparkline chart within the stat card:

```php
Stat::make('Revenue', '$45,678')
    ->chart([7, 2, 10, 3, 15, 4, 17], 'success');
```

### Clickable Stats

Make a stat card link to another page:

```php
Stat::make('Total Users', '12,345')
    ->url('/admin/users')
    ->url('/admin/users', openInNewTab: true);
```

## Grid Layout

Control the number of columns:

```php
StatsWidget::make()
    ->columns(3) // 3 stats per row
    ->stats([...]);
```

## Dynamic Values

Use closures for dynamic values:

```php
Stat::make('Active Users', fn () => User::where('active', true)->count());
```

## Full Example

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
            ->color('primary')
            ->chart([7, 2, 10, 3, 15, 4, 17], 'success'),

        Stat::make('Total Revenue', '$45,678')
            ->description('12% increase')
            ->descriptionIcon('heroicon-m-arrow-trending-up', 'success')
            ->icon('heroicon-o-currency-dollar')
            ->color('success'),

        Stat::make('Active Sessions', '1,234')
            ->description('5% decrease')
            ->descriptionIcon('heroicon-m-arrow-trending-down', 'danger')
            ->icon('heroicon-o-signal')
            ->color('warning'),

        Stat::make('Conversion Rate', '3.2%')
            ->description('0.8% increase')
            ->descriptionIcon('heroicon-m-arrow-trending-up', 'success')
            ->icon('heroicon-o-chart-bar')
            ->color('info')
            ->url('/analytics'),
    ]);
```
