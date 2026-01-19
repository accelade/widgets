<?php

declare(strict_types=1);

namespace Accelade\Widgets\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Accelade\Widgets\Components\StatsWidget stats()
 * @method static \Accelade\Widgets\Components\ChartWidget chart()
 * @method static \Accelade\Widgets\Components\TableWidget table()
 *
 * @see \Accelade\Widgets\WidgetFactory
 */
class Widgets extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'widgets';
    }
}
