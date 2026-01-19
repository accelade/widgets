{{-- Table Widget Section --}}
@props(['prefix' => 'a'])

@php
    use Accelade\Widgets\Components\Column;
    use Accelade\Widgets\Components\TableWidget;

    $tableWidget = TableWidget::make()
        ->heading('Recent Orders')
        ->description('Latest orders from your store')
        ->columns([
            Column::make('id')->label('#')->width('60px'),
            Column::make('customer')->label('Customer')->sortable(),
            Column::make('email')->label('Email'),
            Column::make('amount')
                ->label('Amount')
                ->alignRight()
                ->formatStateUsing(fn ($value) => '$'.number_format($value, 2)),
            Column::make('status')
                ->label('Status')
                ->color(fn ($value) => match ($value) {
                    'completed' => 'success',
                    'pending' => 'warning',
                    'cancelled' => 'danger',
                    default => 'gray',
                }),
            Column::make('date')->label('Date'),
        ])
        ->records([
            ['id' => 1, 'customer' => 'John Doe', 'email' => 'john@example.com', 'amount' => 125.00, 'status' => 'completed', 'date' => '2024-01-15'],
            ['id' => 2, 'customer' => 'Jane Smith', 'email' => 'jane@example.com', 'amount' => 89.50, 'status' => 'pending', 'date' => '2024-01-14'],
            ['id' => 3, 'customer' => 'Bob Wilson', 'email' => 'bob@example.com', 'amount' => 250.00, 'status' => 'completed', 'date' => '2024-01-13'],
            ['id' => 4, 'customer' => 'Alice Brown', 'email' => 'alice@example.com', 'amount' => 175.25, 'status' => 'cancelled', 'date' => '2024-01-12'],
            ['id' => 5, 'customer' => 'Charlie Davis', 'email' => 'charlie@example.com', 'amount' => 320.00, 'status' => 'completed', 'date' => '2024-01-11'],
        ])
        ->striped()
        ->hoverable();

    $emptyTableWidget = TableWidget::make()
        ->heading('Empty Table Demo')
        ->columns([
            Column::make('id')->label('#'),
            Column::make('name')->label('Name'),
        ])
        ->records([])
        ->emptyState('No data available', 'Try adding some records to see them here.');

    $compactTableWidget = TableWidget::make()
        ->heading('Products')
        ->columns([
            Column::make('name')->label('Product'),
            Column::make('price')
                ->label('Price')
                ->alignRight()
                ->formatStateUsing(fn ($value) => '$'.number_format($value, 2)),
            Column::make('stock')
                ->label('Stock')
                ->alignCenter()
                ->color(fn ($value) => $value > 10 ? 'success' : ($value > 0 ? 'warning' : 'danger')),
        ])
        ->records([
            ['name' => 'Laptop Pro', 'price' => 1299.99, 'stock' => 25],
            ['name' => 'Wireless Mouse', 'price' => 49.99, 'stock' => 5],
            ['name' => 'USB-C Hub', 'price' => 79.99, 'stock' => 0],
            ['name' => 'Mechanical Keyboard', 'price' => 149.99, 'stock' => 12],
        ])
        ->bordered();
@endphp

<section class="rounded-xl p-6 mb-6 border border-[var(--docs-border)]" style="background: var(--docs-bg-alt);">
    <div class="flex items-center gap-3 mb-2">
        <span class="w-2.5 h-2.5 bg-amber-500 rounded-full"></span>
        <h3 class="text-lg font-semibold" style="color: var(--docs-text);">Table Widget</h3>
    </div>
    <p class="text-sm mb-4" style="color: var(--docs-text-muted);">
        Display tabular data with sorting, formatting, color-coded statuses, and customizable columns.
    </p>

    <div class="space-y-6 mb-4">
        <!-- Full Featured Table -->
        <div class="rounded-xl p-4 border border-indigo-500/30" style="background: rgba(99, 102, 241, 0.1);">
            <h4 class="font-medium mb-3 flex items-center gap-2" style="color: var(--docs-text);">
                <span class="text-xs px-2 py-1 bg-indigo-500/20 text-indigo-500 rounded">Full</span>
                Full Featured Table
            </h4>
            <x-widgets::table-widget :widget="$tableWidget" />
        </div>

        <!-- Compact Table -->
        <div class="rounded-xl p-4 border border-emerald-500/30" style="background: rgba(16, 185, 129, 0.1);">
            <h4 class="font-medium mb-3 flex items-center gap-2" style="color: var(--docs-text);">
                <span class="text-xs px-2 py-1 bg-emerald-500/20 text-emerald-500 rounded">Bordered</span>
                Bordered Table with Stock Colors
            </h4>
            <x-widgets::table-widget :widget="$compactTableWidget" />
        </div>

        <!-- Empty State Table -->
        <div class="rounded-xl p-4 border border-amber-500/30" style="background: rgba(245, 158, 11, 0.1);">
            <h4 class="font-medium mb-3 flex items-center gap-2" style="color: var(--docs-text);">
                <span class="text-xs px-2 py-1 bg-amber-500/20 text-amber-500 rounded">Empty</span>
                Empty State
            </h4>
            <x-widgets::table-widget :widget="$emptyTableWidget" />
        </div>
    </div>

    <x-accelade::code-block language="php" filename="table-widget-example.php">
use Accelade\Widgets\Components\TableWidget;
use Accelade\Widgets\Components\Column;

$widget = TableWidget::make()
    ->heading('Recent Orders')
    ->description('Latest orders from your store')
    ->columns([
        Column::make('id')->label('#')->width('60px'),
        Column::make('customer')->label('Customer')->sortable(),
        Column::make('email')->label('Email'),
        Column::make('amount')
            ->label('Amount')
            ->alignRight()
            ->formatStateUsing(fn ($value) => '$'.number_format($value, 2)),
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
    ->hoverable()
    ->emptyState('No orders found', 'Try adjusting your filters.');

// Table styling options
$widget->striped();     // Zebra striping
$widget->hoverable();   // Hover highlight
$widget->bordered();    // Add borders
    </x-accelade::code-block>
</section>
