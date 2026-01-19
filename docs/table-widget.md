# Table Widget

The Table Widget displays tabular data with sortable columns, formatting, and styling options.

## Basic Usage

```php
use Accelade\Widgets\Components\TableWidget;
use Accelade\Widgets\Components\Column;

$widget = TableWidget::make()
    ->heading('Recent Orders')
    ->columns([
        Column::make('id')->label('#'),
        Column::make('customer')->label('Customer'),
        Column::make('amount')->label('Amount'),
        Column::make('status')->label('Status'),
    ])
    ->records($orders);
```

```blade
<x-widgets::table-widget :widget="$widget" />
```

## Column Configuration

### Basic Column

```php
Column::make('name'); // Label auto-generated as "Name"
Column::make('name')->label('Full Name');
```

### Alignment

```php
Column::make('amount')->alignRight();
Column::make('status')->alignCenter();
Column::make('name')->alignLeft(); // Default
```

### Width

```php
Column::make('id')->width('60px');
Column::make('description')->width('300px');
```

### Formatting

Format the displayed value:

```php
Column::make('amount')
    ->formatStateUsing(fn ($value) => '$' . number_format($value, 2));

Column::make('created_at')
    ->formatStateUsing(fn ($value) => $value->format('M d, Y'));
```

### Colors

Apply colors based on value:

```php
// Static color
Column::make('status')->color('success');

// Dynamic color
Column::make('status')
    ->color(fn ($value) => match ($value) {
        'completed' => 'success',
        'pending' => 'warning',
        'cancelled' => 'danger',
        default => 'gray',
    });
```

Available colors: `success`, `warning`, `danger`, `info`, `primary`.

### Sortable

```php
Column::make('name')->sortable();
Column::make('created_at')->sortable();
```

### Searchable

```php
Column::make('email')->searchable();
```

### Hidden Columns

```php
Column::make('id')->hidden();
```

### Text Wrapping

```php
Column::make('description')->wrap(); // Enable text wrapping
```

## Table Configuration

### Heading & Description

```php
TableWidget::make()
    ->heading('Recent Orders')
    ->description('Latest orders from your store');
```

### Striped Rows

```php
TableWidget::make()->striped();
```

### Hoverable Rows

```php
TableWidget::make()->hoverable(); // Default: true
TableWidget::make()->hoverable(false);
```

### Bordered

```php
TableWidget::make()->bordered();
```

### Compact Mode

```php
TableWidget::make()->compact();
```

### Clickable Rows

Make rows clickable:

```php
TableWidget::make()
    ->recordUrl(fn ($record) => route('orders.show', $record['id']));
```

### Empty State

Customize the empty state:

```php
TableWidget::make()
    ->emptyState(
        heading: 'No orders found',
        description: 'Try adjusting your search or filters.',
        icon: 'heroicon-o-inbox'
    );
```

### Pagination

```php
TableWidget::make()
    ->paginated(true, perPage: 25);
```

## Data Sources

### Array Data

```php
TableWidget::make()
    ->records([
        ['id' => 1, 'name' => 'John', 'email' => 'john@example.com'],
        ['id' => 2, 'name' => 'Jane', 'email' => 'jane@example.com'],
    ]);
```

### Collection

```php
TableWidget::make()
    ->records(User::all());
```

### Closure

```php
TableWidget::make()
    ->records(fn () => Order::latest()->take(10)->get());
```

### Paginator

```php
TableWidget::make()
    ->records(Order::latest()->paginate(10))
    ->paginated();
```

## Full Example

```php
use Accelade\Widgets\Components\TableWidget;
use Accelade\Widgets\Components\Column;

$widget = TableWidget::make()
    ->heading('Recent Orders')
    ->description('Latest orders from your store')
    ->columns([
        Column::make('id')
            ->label('#')
            ->width('60px')
            ->alignCenter(),

        Column::make('customer')
            ->label('Customer')
            ->sortable()
            ->searchable(),

        Column::make('email')
            ->label('Email'),

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

        Column::make('date')
            ->label('Date')
            ->formatStateUsing(fn ($value) => \Carbon\Carbon::parse($value)->format('M d, Y')),
    ])
    ->records([
        ['id' => 1, 'customer' => 'John Doe', 'email' => 'john@example.com', 'amount' => 125.00, 'status' => 'completed', 'date' => '2024-01-15'],
        ['id' => 2, 'customer' => 'Jane Smith', 'email' => 'jane@example.com', 'amount' => 89.50, 'status' => 'pending', 'date' => '2024-01-14'],
        ['id' => 3, 'customer' => 'Bob Wilson', 'email' => 'bob@example.com', 'amount' => 250.00, 'status' => 'completed', 'date' => '2024-01-13'],
        ['id' => 4, 'customer' => 'Alice Brown', 'email' => 'alice@example.com', 'amount' => 175.25, 'status' => 'cancelled', 'date' => '2024-01-12'],
        ['id' => 5, 'customer' => 'Charlie Davis', 'email' => 'charlie@example.com', 'amount' => 320.00, 'status' => 'completed', 'date' => '2024-01-11'],
    ])
    ->striped()
    ->hoverable()
    ->recordUrl(fn ($record) => '/orders/' . $record['id'])
    ->emptyState('No orders found', 'Try adjusting your filters.');
```
