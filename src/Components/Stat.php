<?php

declare(strict_types=1);

namespace Accelade\Widgets\Components;

use Closure;

/**
 * Individual stat card for StatsWidget.
 */
class Stat
{
    protected string $id = '';

    protected string $label = '';

    protected string|int|float|Closure $value = '';

    protected ?string $description = null;

    protected ?string $descriptionIcon = null;

    protected ?string $descriptionColor = null;

    protected ?string $icon = null;

    protected ?string $iconColor = null;

    protected ?string $color = null;

    protected ?array $chart = null;

    protected ?string $chartColor = null;

    protected ?string $url = null;

    protected bool $openUrlInNewTab = false;

    protected array $extraAttributes = [];

    /**
     * Create a new stat instance.
     */
    public static function make(string $label, string|int|float|Closure $value = ''): static
    {
        $static = new static;
        $static->id = 'stat-'.uniqid();
        $static->label = $label;
        $static->value = $value;

        return $static;
    }

    /**
     * Set the ID.
     */
    public function id(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the ID.
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Set the label.
     */
    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get the label.
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Set the value.
     */
    public function value(string|int|float|Closure $value): static
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value.
     */
    public function getValue(): string|int|float
    {
        if ($this->value instanceof Closure) {
            return ($this->value)();
        }

        return $this->value;
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
     * Set the description icon.
     */
    public function descriptionIcon(?string $icon, ?string $color = null): static
    {
        $this->descriptionIcon = $icon;
        $this->descriptionColor = $color;

        return $this;
    }

    /**
     * Get the description icon.
     */
    public function getDescriptionIcon(): ?string
    {
        return $this->descriptionIcon;
    }

    /**
     * Get the description color.
     */
    public function getDescriptionColor(): ?string
    {
        return $this->descriptionColor;
    }

    /**
     * Set the main icon.
     */
    public function icon(?string $icon, ?string $color = null): static
    {
        $this->icon = $icon;
        $this->iconColor = $color;

        return $this;
    }

    /**
     * Get the icon.
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * Get the icon color.
     */
    public function getIconColor(): ?string
    {
        return $this->iconColor;
    }

    /**
     * Set the card color/theme.
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
     * Set a mini chart to display.
     *
     * @param  array<int|float>  $data
     */
    public function chart(array $data, ?string $color = null): static
    {
        $this->chart = $data;
        $this->chartColor = $color;

        return $this;
    }

    /**
     * Get the chart data.
     *
     * @return array<int|float>|null
     */
    public function getChart(): ?array
    {
        return $this->chart;
    }

    /**
     * Get the chart color.
     */
    public function getChartColor(): ?string
    {
        return $this->chartColor;
    }

    /**
     * Set a URL for the stat card.
     */
    public function url(?string $url, bool $openInNewTab = false): static
    {
        $this->url = $url;
        $this->openUrlInNewTab = $openInNewTab;

        return $this;
    }

    /**
     * Get the URL.
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * Check if URL opens in new tab.
     */
    public function shouldOpenUrlInNewTab(): bool
    {
        return $this->openUrlInNewTab;
    }

    /**
     * Add extra HTML attributes.
     */
    public function extraAttributes(array $attributes): static
    {
        $this->extraAttributes = array_merge($this->extraAttributes, $attributes);

        return $this;
    }

    /**
     * Get extra attributes.
     */
    public function getExtraAttributes(): array
    {
        return $this->extraAttributes;
    }

    /**
     * Serialize to array for JSON output.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'value' => $this->getValue(),
            'description' => $this->description,
            'descriptionIcon' => $this->descriptionIcon,
            'descriptionColor' => $this->descriptionColor,
            'icon' => $this->icon,
            'iconColor' => $this->iconColor,
            'color' => $this->color,
            'chart' => $this->chart,
            'chartColor' => $this->chartColor,
            'url' => $this->url,
            'openUrlInNewTab' => $this->openUrlInNewTab,
        ];
    }
}
