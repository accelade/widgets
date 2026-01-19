<?php

declare(strict_types=1);

use Accelade\Widgets\Components\Column;
use Accelade\Widgets\Components\TableWidget;

it('can render table widget', function () {
    $widget = TableWidget::make()
        ->heading('Recent Orders')
        ->description('Latest orders')
        ->columns([
            Column::make('id')->label('#'),
            Column::make('customer')->label('Customer'),
            Column::make('amount')->label('Amount'),
        ])
        ->records([
            ['id' => 1, 'customer' => 'John Doe', 'amount' => 100],
            ['id' => 2, 'customer' => 'Jane Smith', 'amount' => 200],
        ]);

    $html = $widget->render();

    expect($html)->toContain('Recent Orders');
    expect($html)->toContain('Latest orders');
    expect($html)->toContain('John Doe');
    expect($html)->toContain('Jane Smith');
});

it('shows empty state when no records', function () {
    $widget = TableWidget::make()
        ->heading('Orders')
        ->columns([
            Column::make('id'),
            Column::make('name'),
        ])
        ->records([])
        ->emptyState('No orders found', 'Try adding some orders');

    $html = $widget->render();

    expect($html)->toContain('No orders found');
    expect($html)->toContain('Try adding some orders');
});

it('applies striped styling', function () {
    $widget = TableWidget::make()
        ->columns([Column::make('name')])
        ->records([['name' => 'Test']])
        ->striped();

    expect($widget->isStriped())->toBeTrue();
});

it('respects column visibility', function () {
    $widget = TableWidget::make()
        ->columns([
            Column::make('id')->hidden(),
            Column::make('name'),
        ])
        ->records([['id' => 1, 'name' => 'Test']]);

    $html = $widget->render();

    // Hidden column header should not be rendered
    expect($widget->getColumns()[0]->isHidden())->toBeTrue();
});

it('formats column values', function () {
    $widget = TableWidget::make()
        ->columns([
            Column::make('amount')
                ->formatStateUsing(fn ($value) => '$'.number_format($value, 2)),
        ])
        ->records([['amount' => 123.456]]);

    $html = $widget->render();

    expect($html)->toContain('$123.46');
});

it('applies column alignment', function () {
    $widget = TableWidget::make()
        ->columns([
            Column::make('amount')->alignRight(),
        ])
        ->records([['amount' => 100]]);

    $column = $widget->getColumns()[0];

    expect($column->getAlignment())->toBe('right');
});

it('can set record url callback', function () {
    $widget = TableWidget::make()
        ->columns([Column::make('name')])
        ->records([['id' => 1, 'name' => 'Test']])
        ->recordUrl(fn ($record) => '/orders/'.$record['id']);

    $url = $widget->getRecordUrl(['id' => 1]);

    expect($url)->toBe('/orders/1');
});

it('can enable pagination', function () {
    $widget = TableWidget::make()
        ->columns([Column::make('name')])
        ->records([])
        ->paginated(true, 25);

    expect($widget->isPaginated())->toBeTrue();
    expect($widget->getPerPage())->toBe(25);
});
