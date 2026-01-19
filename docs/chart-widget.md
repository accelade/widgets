# Chart Widget

The Chart Widget displays interactive charts using Chart.js, supporting multiple chart types and configurations.

## Basic Usage

```php
use Accelade\Widgets\Components\ChartWidget;

$widget = ChartWidget::make()
    ->heading('Revenue Overview')
    ->line()
    ->data([
        'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        'datasets' => [
            [
                'label' => 'Revenue',
                'data' => [12000, 19000, 15000, 25000, 22000, 30000],
                'borderColor' => '#3b82f6',
                'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
            ],
        ],
    ]);
```

```blade
<x-widgets::chart-widget :widget="$widget" />
```

## Chart Types

### Line Chart

```php
ChartWidget::make()->line();
```

### Bar Chart

```php
ChartWidget::make()->bar();
```

### Pie Chart

```php
ChartWidget::make()->pie();
```

### Doughnut Chart

```php
ChartWidget::make()->doughnut();
```

### Radar Chart

```php
ChartWidget::make()->radar();
```

### Polar Area Chart

```php
ChartWidget::make()->polarArea();
```

### Scatter Chart

```php
ChartWidget::make()->scatter();
```

### Bubble Chart

```php
ChartWidget::make()->bubble();
```

## Configuration

### Heading & Description

```php
ChartWidget::make()
    ->heading('Revenue Overview')
    ->description('Monthly revenue for the past 12 months');
```

### Height

```php
ChartWidget::make()->height(400); // Height in pixels
```

### Filters

Add filter buttons to switch between different data views:

```php
ChartWidget::make()
    ->filters([
        'week' => 'This Week',
        'month' => 'This Month',
        'year' => 'This Year',
    ], default: 'month');
```

### Chart.js Options

Pass additional Chart.js options:

```php
ChartWidget::make()
    ->options([
        'plugins' => [
            'legend' => ['display' => false],
        ],
        'scales' => [
            'y' => ['beginAtZero' => true],
        ],
    ]);
```

## Data Format

The data follows Chart.js format:

```php
[
    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
    'datasets' => [
        [
            'label' => 'Revenue',
            'data' => [12000, 19000, 15000, 25000, 22000, 30000],
            'borderColor' => '#3b82f6',
            'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
            'tension' => 0.4, // Curved lines
            'fill' => true,   // Fill area under line
        ],
        [
            'label' => 'Expenses',
            'data' => [8000, 12000, 10000, 15000, 14000, 18000],
            'borderColor' => '#ef4444',
            'backgroundColor' => 'rgba(239, 68, 68, 0.1)',
        ],
    ],
]
```

## Dynamic Data

Use closures for dynamic data:

```php
ChartWidget::make()
    ->data(function () {
        $orders = Order::selectRaw('MONTH(created_at) as month, SUM(total) as revenue')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('revenue', 'month')
            ->toArray();

        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => array_values($orders),
                    'borderColor' => '#3b82f6',
                ],
            ],
        ];
    });
```

## Full Example

```php
use Accelade\Widgets\Components\ChartWidget;

$widget = ChartWidget::make()
    ->heading('Sales Performance')
    ->description('Compare sales across different periods')
    ->line()
    ->height(350)
    ->filters([
        'week' => 'This Week',
        'month' => 'This Month',
        'quarter' => 'This Quarter',
        'year' => 'This Year',
    ], 'month')
    ->data([
        'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        'datasets' => [
            [
                'label' => 'This Period',
                'data' => [120, 190, 150, 250, 220, 300, 280],
                'borderColor' => '#3b82f6',
                'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                'tension' => 0.4,
                'fill' => true,
            ],
            [
                'label' => 'Previous Period',
                'data' => [100, 150, 130, 200, 180, 250, 230],
                'borderColor' => '#94a3b8',
                'backgroundColor' => 'transparent',
                'borderDash' => [5, 5],
                'tension' => 0.4,
            ],
        ],
    ])
    ->options([
        'plugins' => [
            'legend' => [
                'position' => 'bottom',
            ],
        ],
    ]);
```
