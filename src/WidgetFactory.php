<?php

declare(strict_types=1);

namespace Accelade\Widgets;

use Accelade\Widgets\Components\ChartWidget;
use Accelade\Widgets\Components\StatsWidget;
use Accelade\Widgets\Components\TableWidget;

/**
 * Factory for creating widget instances.
 */
class WidgetFactory
{
    /**
     * Create a new stats widget.
     */
    public function stats(): StatsWidget
    {
        return StatsWidget::make();
    }

    /**
     * Create a new chart widget.
     */
    public function chart(): ChartWidget
    {
        return ChartWidget::make();
    }

    /**
     * Create a new table widget.
     */
    public function table(): TableWidget
    {
        return TableWidget::make();
    }
}
