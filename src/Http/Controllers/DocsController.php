<?php

declare(strict_types=1);

namespace Accelade\Widgets\Http\Controllers;

use Accelade\Widgets\Components\ChartWidget;
use Accelade\Widgets\Components\Column;
use Accelade\Widgets\Components\Stat;
use Accelade\Widgets\Components\StatsWidget;
use Accelade\Widgets\Components\TableWidget;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class DocsController extends Controller
{
    public function demo(Request $request, ?string $framework = 'vanilla'): View
    {
        $statsWidget = $this->getStatsWidget();
        $chartWidget = $this->getChartWidget();
        $tableWidget = $this->getTableWidget();

        return view('widgets::demo.'.$framework, [
            'statsWidget' => $statsWidget,
            'chartWidget' => $chartWidget,
            'tableWidget' => $tableWidget,
            'framework' => $framework,
        ]);
    }

    public function docs(Request $request, ?string $section = 'getting-started'): View
    {
        return view('widgets::docs.sections.'.$section, [
            'section' => $section,
        ]);
    }

    protected function getStatsWidget(): StatsWidget
    {
        return StatsWidget::make()
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
                    ->color('info'),
            ]);
    }

    protected function getChartWidget(): ChartWidget
    {
        return ChartWidget::make()
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
    }

    protected function getTableWidget(): TableWidget
    {
        return TableWidget::make()
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
    }
}
