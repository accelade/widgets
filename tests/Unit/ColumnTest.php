<?php

declare(strict_types=1);

use Accelade\Widgets\Components\Column;

it('can create a column', function () {
    $column = Column::make('name');

    expect($column->getName())->toBe('name');
    expect($column->getLabel())->toBe('Name');
});

it('can set column label', function () {
    $column = Column::make('name')
        ->label('Full Name');

    expect($column->getLabel())->toBe('Full Name');
});

it('can set column as sortable', function () {
    $column = Column::make('name')->sortable();

    expect($column->isSortable())->toBeTrue();
});

it('can set column as searchable', function () {
    $column = Column::make('name')->searchable();

    expect($column->isSearchable())->toBeTrue();
});

it('can set column alignment', function () {
    $column = Column::make('price')->alignRight();

    expect($column->getAlignment())->toBe('right');
});

it('can set column alignment to center', function () {
    $column = Column::make('status')->alignCenter();

    expect($column->getAlignment())->toBe('center');
});

it('can format state using callback', function () {
    $column = Column::make('price')
        ->formatStateUsing(fn ($value) => '$'.number_format($value, 2));

    $record = ['price' => 123.456];
    $state = $column->getState($record);

    expect($state)->toBe('$123.46');
});

it('can set column icon', function () {
    $column = Column::make('status')
        ->icon('heroicon-o-check', 'after');

    expect($column->getIcon())->toBe('heroicon-o-check');
    expect($column->getIconPosition())->toBe('after');
});

it('can set column color', function () {
    $column = Column::make('status')
        ->color('success');

    expect($column->getColor())->toBe('success');
});

it('can set column color using callback', function () {
    $column = Column::make('status')
        ->color(fn ($value) => $value === 'active' ? 'success' : 'danger');

    $record = ['status' => 'active'];
    expect($column->getColor($record))->toBe('success');

    $record = ['status' => 'inactive'];
    expect($column->getColor($record))->toBe('danger');
});

it('can set column as hidden', function () {
    $column = Column::make('id')->hidden();

    expect($column->isHidden())->toBeTrue();
});

it('can set column width', function () {
    $column = Column::make('id')
        ->width('60px');

    expect($column->getWidth())->toBe('60px');
});

it('can enable text wrapping', function () {
    $column = Column::make('description')->wrap();

    expect($column->shouldWrap())->toBeTrue();
});

it('can convert column to array', function () {
    $column = Column::make('name')
        ->label('Full Name')
        ->sortable()
        ->width('200px');

    $array = $column->toArray();

    expect($array)->toHaveKey('name');
    expect($array)->toHaveKey('label');
    expect($array)->toHaveKey('sortable');
    expect($array)->toHaveKey('width');
    expect($array['name'])->toBe('name');
    expect($array['label'])->toBe('Full Name');
    expect($array['sortable'])->toBeTrue();
});
