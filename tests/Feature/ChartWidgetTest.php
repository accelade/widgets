<?php

declare(strict_types=1);

use Accelade\Widgets\Components\ChartWidget;

it('can render chart widget', function () {
    $widget = ChartWidget::make()
        ->heading('Revenue Overview')
        ->description('Monthly revenue')
        ->line()
        ->height(300)
        ->data([
            'labels' => ['Jan', 'Feb', 'Mar'],
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => [100, 200, 300],
                ],
            ],
        ]);

    $html = $widget->render();

    expect($html)->toContain('Revenue Overview');
    expect($html)->toContain('Monthly revenue');
    expect($html)->toContain('chart-container');
})->skip('Requires accelade/accelade package for chart component');

it('generates chart config', function () {
    $widget = ChartWidget::make()
        ->bar()
        ->data([
            'labels' => ['A', 'B', 'C'],
            'datasets' => [['data' => [1, 2, 3]]],
        ])
        ->options([
            'plugins' => [
                'legend' => ['display' => false],
            ],
        ]);

    $config = $widget->getChartConfig();

    expect($config)->toHaveKey('type');
    expect($config)->toHaveKey('data');
    expect($config)->toHaveKey('options');
    expect($config['type'])->toBe('bar');
    expect($config['options']['responsive'])->toBeTrue();
});

it('can use all chart types', function (string $method, string $expectedType) {
    $widget = ChartWidget::make()->{$method}();

    expect($widget->getType())->toBe($expectedType);
})->with([
    ['line', 'line'],
    ['bar', 'bar'],
    ['pie', 'pie'],
    ['doughnut', 'doughnut'],
    ['radar', 'radar'],
    ['polarArea', 'polarArea'],
    ['scatter', 'scatter'],
    ['bubble', 'bubble'],
]);

it('can set color', function () {
    $widget = ChartWidget::make()
        ->color('primary');

    expect($widget->getColor())->toBe('primary');
});

it('includes filters in rendered output', function () {
    $widget = ChartWidget::make()
        ->heading('Sales')
        ->filters([
            'week' => 'This Week',
            'month' => 'This Month',
            'year' => 'This Year',
        ], 'month')
        ->data(['labels' => [], 'datasets' => []]);

    $html = $widget->render();

    expect($html)->toContain('This Week');
    expect($html)->toContain('This Month');
    expect($html)->toContain('This Year');
})->skip('Requires accelade/accelade package for chart component');
