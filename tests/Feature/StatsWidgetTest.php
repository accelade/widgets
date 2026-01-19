<?php

declare(strict_types=1);

use Accelade\Widgets\Components\Stat;
use Accelade\Widgets\Components\StatsWidget;

it('can render stats widget', function () {
    $widget = StatsWidget::make()
        ->columns(4)
        ->stats([
            Stat::make('Total Users', '12,345')
                ->description('3.5% increase')
                ->color('primary'),
            Stat::make('Revenue', '$45,678')
                ->color('success'),
        ]);

    $html = $widget->render();

    expect($html)->toContain('Total Users');
    expect($html)->toContain('12,345');
    expect($html)->toContain('Revenue');
    expect($html)->toContain('$45,678');
});

it('respects column count', function () {
    $widget = StatsWidget::make()
        ->columns(3)
        ->stats([
            Stat::make('Stat 1', '100'),
            Stat::make('Stat 2', '200'),
            Stat::make('Stat 3', '300'),
        ]);

    expect($widget->getColumns())->toBe(3);
});

it('can set widget id', function () {
    $widget = StatsWidget::make()
        ->id('my-stats-widget');

    expect($widget->getId())->toBe('my-stats-widget');
});

it('can set column span', function () {
    $widget = StatsWidget::make()
        ->columnSpan(6);

    expect($widget->getColumnSpan())->toBe(6);
});

it('can set column span to full', function () {
    $widget = StatsWidget::make()
        ->columnSpanFull();

    expect($widget->getColumnSpan())->toBe('full');
});

it('can set sort order', function () {
    $widget = StatsWidget::make()
        ->sort(10);

    expect($widget->getSort())->toBe(10);
});

it('can enable lazy loading', function () {
    $widget = StatsWidget::make()
        ->lazy(true, 'Loading...');

    expect($widget->isLazy())->toBeTrue();
    expect($widget->getLazyPlaceholder())->toBe('Loading...');
});

it('can set polling interval', function () {
    $widget = StatsWidget::make()
        ->pollingInterval('30s');

    expect($widget->getPollingInterval())->toBe('30s');
});

it('can set visibility', function () {
    $widget = StatsWidget::make()
        ->visible(false);

    expect($widget->isVisible())->toBeFalse();
});

it('can hide widget', function () {
    $widget = StatsWidget::make()
        ->hidden(true);

    expect($widget->isVisible())->toBeFalse();
});

it('hidden widget returns empty string', function () {
    $widget = StatsWidget::make()
        ->hidden(true)
        ->stats([Stat::make('Test', '100')]);

    expect($widget->render())->toBe('');
});

it('can convert to array', function () {
    $widget = StatsWidget::make()
        ->id('test-widget')
        ->columnSpan(6)
        ->sort(5)
        ->pollingInterval('10s');

    $array = $widget->toArray();

    expect($array)->toHaveKey('type');
    expect($array)->toHaveKey('id');
    expect($array)->toHaveKey('columnSpan');
    expect($array)->toHaveKey('sort');
    expect($array)->toHaveKey('pollingInterval');
    expect($array['id'])->toBe('test-widget');
    expect($array['columnSpan'])->toBe(6);
});
