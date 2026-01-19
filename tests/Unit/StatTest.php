<?php

declare(strict_types=1);

use Accelade\Widgets\Components\Stat;

it('can create a stat', function () {
    $stat = Stat::make('Total Users', '12,345');

    expect($stat->getLabel())->toBe('Total Users');
    expect($stat->getValue())->toBe('12,345');
});

it('can set stat description', function () {
    $stat = Stat::make('Users', '100')
        ->description('3.5% increase');

    expect($stat->getDescription())->toBe('3.5% increase');
});

it('can set description icon with color', function () {
    $stat = Stat::make('Users', '100')
        ->descriptionIcon('heroicon-m-arrow-trending-up', 'success');

    expect($stat->getDescriptionIcon())->toBe('heroicon-m-arrow-trending-up');
    expect($stat->getDescriptionColor())->toBe('success');
});

it('can set stat icon', function () {
    $stat = Stat::make('Users', '100')
        ->icon('heroicon-o-users', 'primary');

    expect($stat->getIcon())->toBe('heroicon-o-users');
    expect($stat->getIconColor())->toBe('primary');
});

it('can set stat color', function () {
    $stat = Stat::make('Users', '100')
        ->color('success');

    expect($stat->getColor())->toBe('success');
});

it('can set stat chart', function () {
    $chartData = [7, 2, 10, 3, 15, 4, 17];

    $stat = Stat::make('Users', '100')
        ->chart($chartData, 'success');

    expect($stat->getChart())->toBe($chartData);
    expect($stat->getChartColor())->toBe('success');
});

it('can set stat url', function () {
    $stat = Stat::make('Users', '100')
        ->url('/users', true);

    expect($stat->getUrl())->toBe('/users');
    expect($stat->shouldOpenUrlInNewTab())->toBeTrue();
});

it('can convert stat to array', function () {
    $stat = Stat::make('Users', '100')
        ->description('Increase')
        ->color('primary');

    $array = $stat->toArray();

    expect($array)->toHaveKey('label');
    expect($array)->toHaveKey('value');
    expect($array)->toHaveKey('description');
    expect($array)->toHaveKey('color');
    expect($array['label'])->toBe('Users');
    expect($array['value'])->toBe('100');
});

it('can use closure for value', function () {
    $stat = Stat::make('Users', fn () => 100 + 50);

    expect($stat->getValue())->toBe(150);
});
