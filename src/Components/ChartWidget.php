<?php

declare(strict_types=1);

namespace Accelade\Widgets\Components;

use Accelade\Widgets\Widget;
use Closure;

/**
 * Chart widget for displaying various chart types.
 */
class ChartWidget extends Widget
{
    protected string $type = 'line';

    protected string $heading = '';

    protected ?string $description = null;

    protected array $data = [];

    protected array $options = [];

    protected int $height = 300;

    protected ?string $color = null;

    protected array $filters = [];

    protected ?string $activeFilter = null;

    /**
     * Available chart types.
     */
    public const TYPE_LINE = 'line';

    public const TYPE_BAR = 'bar';

    public const TYPE_PIE = 'pie';

    public const TYPE_DOUGHNUT = 'doughnut';

    public const TYPE_RADAR = 'radar';

    public const TYPE_POLAR = 'polarArea';

    public const TYPE_SCATTER = 'scatter';

    public const TYPE_BUBBLE = 'bubble';

    /**
     * Set the chart type.
     */
    public function type(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the chart type.
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set as line chart.
     */
    public function line(): static
    {
        return $this->type(self::TYPE_LINE);
    }

    /**
     * Set as bar chart.
     */
    public function bar(): static
    {
        return $this->type(self::TYPE_BAR);
    }

    /**
     * Set as pie chart.
     */
    public function pie(): static
    {
        return $this->type(self::TYPE_PIE);
    }

    /**
     * Set as doughnut chart.
     */
    public function doughnut(): static
    {
        return $this->type(self::TYPE_DOUGHNUT);
    }

    /**
     * Set as radar chart.
     */
    public function radar(): static
    {
        return $this->type(self::TYPE_RADAR);
    }

    /**
     * Set as polar area chart.
     */
    public function polarArea(): static
    {
        return $this->type(self::TYPE_POLAR);
    }

    /**
     * Set as scatter chart.
     */
    public function scatter(): static
    {
        return $this->type(self::TYPE_SCATTER);
    }

    /**
     * Set as bubble chart.
     */
    public function bubble(): static
    {
        return $this->type(self::TYPE_BUBBLE);
    }

    /**
     * Set the heading.
     */
    public function heading(string $heading): static
    {
        $this->heading = $heading;

        return $this;
    }

    /**
     * Get the heading.
     */
    public function getHeading(): string
    {
        return $this->heading;
    }

    /**
     * Set the description.
     */
    public function description(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the description.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set the chart data.
     */
    public function data(array|Closure $data): static
    {
        $this->data = $this->evaluate($data);

        return $this;
    }

    /**
     * Get the chart data.
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Set chart options.
     */
    public function options(array $options): static
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    /**
     * Get chart options.
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Set the chart height.
     */
    public function height(int $height): static
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get the chart height.
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * Set the chart color theme.
     */
    public function color(?string $color): static
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get the color.
     */
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * Set filter options for the chart.
     *
     * @param  array<string, string>  $filters  Key => Label pairs
     */
    public function filters(array $filters, ?string $default = null): static
    {
        $this->filters = $filters;
        $this->activeFilter = $default ?? array_key_first($filters);

        return $this;
    }

    /**
     * Get the filters.
     *
     * @return array<string, string>
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * Get the active filter.
     */
    public function getActiveFilter(): ?string
    {
        return $this->activeFilter;
    }

    /**
     * Get the full Chart.js configuration.
     */
    public function getChartConfig(): array
    {
        return [
            'type' => $this->type,
            'data' => $this->data,
            'options' => array_merge([
                'responsive' => true,
                'maintainAspectRatio' => false,
            ], $this->options),
        ];
    }

    protected function getView(): string
    {
        return 'widgets::components.chart-widget';
    }

    protected function getViewData(): array
    {
        return [
            'widget' => $this,
            'heading' => $this->getHeading(),
            'description' => $this->getDescription(),
            'chartConfig' => $this->getChartConfig(),
            'height' => $this->getHeight(),
            'filters' => $this->getFilters(),
            'activeFilter' => $this->getActiveFilter(),
        ];
    }
}
