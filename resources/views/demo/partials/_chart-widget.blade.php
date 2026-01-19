{{-- Chart Widget Section --}}
@props(['prefix' => 'a'])

@php
    use Accelade\Widgets\Components\ChartWidget;

    $lineChart = ChartWidget::make()
        ->heading('Revenue Overview')
        ->description('Monthly revenue for the past 12 months')
        ->line()
        ->height(300)
        ->filters([
            'week' => 'This Week',
            'month' => 'This Month',
            'year' => 'This Year',
        ], 'month')
        ->data([
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => [12000, 19000, 15000, 25000, 22000, 30000, 28000, 35000, 32000, 40000, 38000, 45000],
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'tension' => 0.4,
                    'fill' => true,
                ],
            ],
        ]);

    $barChart = ChartWidget::make()
        ->heading('Sales by Category')
        ->bar()
        ->height(250)
        ->data([
            'labels' => ['Electronics', 'Clothing', 'Home', 'Sports', 'Books'],
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => [4500, 3200, 2800, 2100, 1500],
                    'backgroundColor' => [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(139, 92, 246, 0.8)',
                    ],
                ],
            ],
        ]);

    $doughnutChart = ChartWidget::make()
        ->heading('Traffic Sources')
        ->doughnut()
        ->height(250)
        ->data([
            'labels' => ['Direct', 'Organic', 'Referral', 'Social', 'Email'],
            'datasets' => [
                [
                    'data' => [35, 25, 20, 15, 5],
                    'backgroundColor' => [
                        '#3b82f6',
                        '#22c55e',
                        '#f59e0b',
                        '#ef4444',
                        '#8b5cf6',
                    ],
                ],
            ],
        ]);

    $radarChart = ChartWidget::make()
        ->heading('Skills Assessment')
        ->radar()
        ->height(250)
        ->data([
            'labels' => ['JavaScript', 'PHP', 'Python', 'Vue', 'React', 'Laravel'],
            'datasets' => [
                [
                    'label' => 'Developer A',
                    'data' => [85, 90, 70, 80, 75, 95],
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                ],
                [
                    'label' => 'Developer B',
                    'data' => [70, 75, 90, 85, 80, 60],
                    'borderColor' => '#22c55e',
                    'backgroundColor' => 'rgba(34, 197, 94, 0.2)',
                ],
            ],
        ]);
@endphp

<section class="rounded-xl p-6 mb-6 border border-[var(--docs-border)]" style="background: var(--docs-bg-alt);">
    <div class="flex items-center gap-3 mb-2">
        <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full"></span>
        <h3 class="text-lg font-semibold" style="color: var(--docs-text);">Chart Widget</h3>
    </div>
    <p class="text-sm mb-4" style="color: var(--docs-text-muted);">
        Display various chart types using Chart.js with support for line, bar, pie, doughnut, radar, and more.
    </p>

    <div class="space-y-6 mb-4">
        <!-- Line Chart -->
        <div class="rounded-xl p-4 border border-indigo-500/30" style="background: rgba(99, 102, 241, 0.1);">
            <h4 class="font-medium mb-3 flex items-center gap-2" style="color: var(--docs-text);">
                <span class="text-xs px-2 py-1 bg-indigo-500/20 text-indigo-500 rounded">Line</span>
                Line Chart with Filters
            </h4>
            <x-widgets::chart-widget :widget="$lineChart" />
        </div>

        <!-- Bar and Doughnut Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div class="rounded-xl p-4 border border-emerald-500/30" style="background: rgba(16, 185, 129, 0.1);">
                <h4 class="font-medium mb-3 flex items-center gap-2" style="color: var(--docs-text);">
                    <span class="text-xs px-2 py-1 bg-emerald-500/20 text-emerald-500 rounded">Bar</span>
                    Bar Chart
                </h4>
                <x-widgets::chart-widget :widget="$barChart" />
            </div>

            <div class="rounded-xl p-4 border border-amber-500/30" style="background: rgba(245, 158, 11, 0.1);">
                <h4 class="font-medium mb-3 flex items-center gap-2" style="color: var(--docs-text);">
                    <span class="text-xs px-2 py-1 bg-amber-500/20 text-amber-500 rounded">Doughnut</span>
                    Doughnut Chart
                </h4>
                <x-widgets::chart-widget :widget="$doughnutChart" />
            </div>
        </div>

        <!-- Radar Chart -->
        <div class="rounded-xl p-4 border border-sky-500/30" style="background: rgba(14, 165, 233, 0.1);">
            <h4 class="font-medium mb-3 flex items-center gap-2" style="color: var(--docs-text);">
                <span class="text-xs px-2 py-1 bg-sky-500/20 text-sky-500 rounded">Radar</span>
                Radar Chart (Multi-Dataset)
            </h4>
            <div class="max-w-md mx-auto">
                <x-widgets::chart-widget :widget="$radarChart" />
            </div>
        </div>
    </div>

    <x-accelade::code-block language="php" filename="chart-widget-example.php">
use Accelade\Widgets\Components\ChartWidget;

// Line Chart
$chart = ChartWidget::make()
    ->heading('Revenue Overview')
    ->description('Monthly revenue for the past 12 months')
    ->line()
    ->height(350)
    ->filters([
        'week' => 'This Week',
        'month' => 'This Month',
        'year' => 'This Year',
    ], 'month')
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

// Bar Chart
$barChart = ChartWidget::make()
    ->heading('Sales by Category')
    ->bar()
    ->data([...]);

// Doughnut Chart
$doughnutChart = ChartWidget::make()
    ->heading('Traffic Sources')
    ->doughnut()
    ->data([...]);

// Other types: pie(), radar(), polarArea(), scatter(), bubble()
    </x-accelade::code-block>
</section>
