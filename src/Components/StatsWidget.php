<?php

declare(strict_types=1);

namespace Accelade\Widgets\Components;

use Accelade\Widgets\Widget;
use Closure;

/**
 * Stats overview widget for displaying key metrics.
 */
class StatsWidget extends Widget
{
    /** @var array<Stat> */
    protected array $stats = [];

    protected int $columns = 4;

    /**
     * Set the stats to display.
     *
     * @param  array<Stat>|Closure  $stats
     */
    public function stats(array|Closure $stats): static
    {
        $this->stats = $this->evaluate($stats);

        return $this;
    }

    /**
     * Get the stats.
     *
     * @return array<Stat>
     */
    public function getStats(): array
    {
        return $this->stats;
    }

    /**
     * Set the number of columns.
     */
    public function columns(int $columns): static
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * Get the number of columns.
     */
    public function getColumns(): int
    {
        return $this->columns;
    }

    protected function getView(): string
    {
        return 'widgets::components.stats-widget';
    }

    protected function getViewData(): array
    {
        return [
            'widget' => $this,
            'stats' => $this->getStats(),
            'columns' => $this->getColumns(),
        ];
    }
}
