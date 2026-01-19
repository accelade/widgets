{{-- Stats Widget Section --}}
@props(['prefix' => 'a'])

@php
    use Accelade\Widgets\Components\Stat;
    use Accelade\Widgets\Components\StatsWidget;

    // Basic Stats Widget
    $basicStatsWidget = StatsWidget::make()
        ->columns(3)
        ->stats([
            Stat::make('Total Users', '12,345')
                ->description('3.5% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up', 'success')
                ->icon('heroicon-o-users')
                ->color('primary'),

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
        ]);

    // Stats with Charts
    $chartStatsWidget = StatsWidget::make()
        ->columns(3)
        ->stats([
            Stat::make('Revenue', '$45,678')
                ->description('Revenue this month')
                ->chart([7, 2, 10, 3, 15, 4, 17], 'success')
                ->color('success'),

            Stat::make('Visitors', '8,234')
                ->description('Unique visitors')
                ->chart([3, 8, 5, 12, 6, 9, 4], 'primary')
                ->color('primary'),

            Stat::make('Bounce Rate', '32%')
                ->description('Reduced by 5%')
                ->chart([15, 12, 18, 10, 8, 14, 11], 'warning')
                ->color('warning'),
        ]);

    // Simple Stats (no icons)
    $simpleStatsWidget = StatsWidget::make()
        ->columns(3)
        ->stats([
            Stat::make('Total Orders', '1,234'),
            Stat::make('Pending', '45'),
            Stat::make('Completed', '1,189'),
        ]);

    // Clickable Stats
    $clickableStatsWidget = StatsWidget::make()
        ->columns(3)
        ->stats([
            Stat::make('Users', '12,345')
                ->icon('heroicon-o-users')
                ->color('primary')
                ->url('/admin/users'),

            Stat::make('Products', '567')
                ->icon('heroicon-o-cube')
                ->color('success')
                ->url('/admin/products'),

            Stat::make('Orders', '890')
                ->icon('heroicon-o-shopping-cart')
                ->color('warning')
                ->url('/admin/orders'),
        ]);
@endphp

<section class="rounded-xl p-6 mb-6 border border-[var(--docs-border)]" style="background: var(--docs-bg-alt);">
    <div class="flex items-center gap-3 mb-2">
        <span class="w-2.5 h-2.5 bg-indigo-500 rounded-full"></span>
        <h3 class="text-lg font-semibold" style="color: var(--docs-text);">Stats Widget</h3>
    </div>
    <p class="text-sm mb-4" style="color: var(--docs-text-muted);">
        Display key metrics and statistics in a card-based layout with icons, descriptions, and mini charts.
    </p>

    <div class="space-y-6 mb-4">
        <!-- Basic Stats -->
        <div class="rounded-xl p-4 border border-indigo-500/30" style="background: rgba(99, 102, 241, 0.1);">
            <h4 class="font-medium mb-3 flex items-center gap-2" style="color: var(--docs-text);">
                <span class="text-xs px-2 py-1 bg-indigo-500/20 text-indigo-500 rounded">Basic</span>
                Full Featured Stats
            </h4>
            <x-widgets::stats-widget :widget="$basicStatsWidget" />
        </div>

        <!-- Stats with Charts -->
        <div class="rounded-xl p-4 border border-emerald-500/30" style="background: rgba(16, 185, 129, 0.1);">
            <h4 class="font-medium mb-3 flex items-center gap-2" style="color: var(--docs-text);">
                <span class="text-xs px-2 py-1 bg-emerald-500/20 text-emerald-500 rounded">Charts</span>
                Stats with Mini Charts
            </h4>
            <x-widgets::stats-widget :widget="$chartStatsWidget" />
        </div>

        <!-- Simple Stats -->
        <div class="rounded-xl p-4 border border-amber-500/30" style="background: rgba(245, 158, 11, 0.1);">
            <h4 class="font-medium mb-3 flex items-center gap-2" style="color: var(--docs-text);">
                <span class="text-xs px-2 py-1 bg-amber-500/20 text-amber-500 rounded">Simple</span>
                Simple Stats (No Icons)
            </h4>
            <x-widgets::stats-widget :widget="$simpleStatsWidget" />
        </div>

        <!-- Clickable Stats -->
        <div class="rounded-xl p-4 border border-sky-500/30" style="background: rgba(14, 165, 233, 0.1);">
            <h4 class="font-medium mb-3 flex items-center gap-2" style="color: var(--docs-text);">
                <span class="text-xs px-2 py-1 bg-sky-500/20 text-sky-500 rounded">Links</span>
                Clickable Stats with URLs
            </h4>
            <x-widgets::stats-widget :widget="$clickableStatsWidget" />
        </div>
    </div>

    <x-accelade::code-block language="php" filename="stats-widget-example.php">
use Accelade\Widgets\Components\StatsWidget;
use Accelade\Widgets\Components\Stat;

$widget = StatsWidget::make()
    ->columns(3)
    ->stats([
        Stat::make('Total Users', '12,345')
            ->description('3.5% increase')
            ->descriptionIcon('heroicon-m-arrow-trending-up', 'success')
            ->icon('heroicon-o-users')
            ->color('primary')
            ->chart([7, 2, 10, 3, 15, 4, 17]),

        Stat::make('Total Revenue', '$45,678')
            ->description('12% increase')
            ->descriptionIcon('heroicon-m-arrow-trending-up', 'success')
            ->icon('heroicon-o-currency-dollar')
            ->color('success'),

        Stat::make('Active Sessions', '1,234')
            ->description('5% decrease')
            ->descriptionIcon('heroicon-m-arrow-trending-down', 'danger')
            ->icon('heroicon-o-signal')
            ->color('warning')
            ->url('/sessions'),
    ]);
    </x-accelade::code-block>
</section>
