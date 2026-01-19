<x-widgets::layouts.docs section="getting-started" title="Getting Started">
    <div class="prose prose-slate dark:prose-invert max-w-none">
        <h1>Getting Started with Accelade Widgets</h1>

        <p class="lead">
            Accelade Widgets provides a powerful set of dashboard components for Laravel applications.
            Build beautiful, interactive dashboards with minimal code.
        </p>

        <h2>Installation</h2>

        <p>Install the package via Composer:</p>

        <pre><code class="language-bash">composer require accelade/widgets</code></pre>

        <h2>Quick Start</h2>

        <h3>Stats Widget</h3>

        <p>Display key metrics with the StatsWidget:</p>

        <pre><code class="language-php">use Accelade\Widgets\Components\StatsWidget;
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
    ]);</code></pre>

        <p>Then in your Blade template:</p>

        <pre><code class="language-blade">&lt;x-widgets::stats-widget :widget="$widget" /&gt;</code></pre>

        <h3>Chart Widget</h3>

        <p>Display charts using Chart.js:</p>

        <pre><code class="language-php">use Accelade\Widgets\Components\ChartWidget;

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
    ]);</code></pre>

        <h3>Table Widget</h3>

        <p>Display tabular data with the TableWidget:</p>

        <pre><code class="language-php">use Accelade\Widgets\Components\TableWidget;
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
    ->hoverable();</code></pre>

        <h2>Grid Layout</h2>

        <p>Arrange widgets in a responsive grid:</p>

        <pre><code class="language-blade">&lt;x-widgets::grid :columns="12" :gap="6"&gt;
    &lt;div class="col-span-8"&gt;
        &lt;x-widgets::chart-widget :widget="$chartWidget" /&gt;
    &lt;/div&gt;
    &lt;div class="col-span-4"&gt;
        &lt;x-widgets::stats-widget :widget="$statsWidget" /&gt;
    &lt;/div&gt;
&lt;/x-widgets::grid&gt;</code></pre>

        <h2>Configuration</h2>

        <p>Publish the configuration file:</p>

        <pre><code class="language-bash">php artisan vendor:publish --tag=widgets-config</code></pre>

        <p>This will create a <code>config/widgets.php</code> file where you can customize default settings.</p>

        <h2>Available Widgets</h2>

        <ul>
            <li><strong>StatsWidget</strong> - Display key metrics and statistics</li>
            <li><strong>ChartWidget</strong> - Line, bar, pie, and other chart types</li>
            <li><strong>TableWidget</strong> - Display tabular data with sorting and formatting</li>
        </ul>

        <h2>Features</h2>

        <ul>
            <li>Filament-compatible API</li>
            <li>Dark mode support</li>
            <li>Responsive design</li>
            <li>Chart.js integration</li>
            <li>Polling/auto-refresh support</li>
            <li>Lazy loading</li>
            <li>Grid layout system</li>
        </ul>
    </div>
</x-widgets::layouts.docs>
