<?php

declare(strict_types=1);

use Accelade\Widgets\Components\ChartWidget;
use Accelade\Widgets\Components\StatsWidget;
use Accelade\Widgets\Components\TableWidget;

it('can create a stats widget', function () {
    $widget = StatsWidget::make();

    expect($widget)->toBeInstanceOf(StatsWidget::class);
    expect($widget->getId())->not->toBeEmpty();
});

it('can set columns on stats widget', function () {
    $widget = StatsWidget::make()->columns(3);

    expect($widget->getColumns())->toBe(3);
});

it('can create a chart widget', function () {
    $widget = ChartWidget::make();

    expect($widget)->toBeInstanceOf(ChartWidget::class);
    expect($widget->getType())->toBe('line');
});

it('can set chart type', function () {
    $widget = ChartWidget::make()->bar();

    expect($widget->getType())->toBe('bar');
});

it('can set chart heading and description', function () {
    $widget = ChartWidget::make()
        ->heading('Revenue Overview')
        ->description('Monthly revenue');

    expect($widget->getHeading())->toBe('Revenue Overview');
    expect($widget->getDescription())->toBe('Monthly revenue');
});

it('can set chart height', function () {
    $widget = ChartWidget::make()->height(400);

    expect($widget->getHeight())->toBe(400);
});

it('can set chart data', function () {
    $data = [
        'labels' => ['Jan', 'Feb', 'Mar'],
        'datasets' => [
            ['label' => 'Sales', 'data' => [100, 200, 300]],
        ],
    ];

    $widget = ChartWidget::make()->data($data);

    expect($widget->getData())->toBe($data);
});

it('can set chart filters', function () {
    $widget = ChartWidget::make()
        ->filters([
            'week' => 'This Week',
            'month' => 'This Month',
        ], 'week');

    expect($widget->getFilters())->toBe([
        'week' => 'This Week',
        'month' => 'This Month',
    ]);
    expect($widget->getActiveFilter())->toBe('week');
});

it('can create a table widget', function () {
    $widget = TableWidget::make();

    expect($widget)->toBeInstanceOf(TableWidget::class);
});

it('can set table heading and description', function () {
    $widget = TableWidget::make()
        ->heading('Recent Orders')
        ->description('Latest orders');

    expect($widget->getHeading())->toBe('Recent Orders');
    expect($widget->getDescription())->toBe('Latest orders');
});

it('can set table striped option', function () {
    $widget = TableWidget::make()->striped();

    expect($widget->isStriped())->toBeTrue();
});

it('can set table hoverable option', function () {
    $widget = TableWidget::make()->hoverable(false);

    expect($widget->isHoverable())->toBeFalse();
});

it('can set table bordered option', function () {
    $widget = TableWidget::make()->bordered();

    expect($widget->isBordered())->toBeTrue();
});

it('can set table compact option', function () {
    $widget = TableWidget::make()->compact();

    expect($widget->isCompact())->toBeTrue();
});

it('can set empty state', function () {
    $widget = TableWidget::make()
        ->emptyState('No data', 'Try adding some records');

    expect($widget->getEmptyStateHeading())->toBe('No data');
    expect($widget->getEmptyStateDescription())->toBe('Try adding some records');
});
