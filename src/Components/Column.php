<?php

declare(strict_types=1);

namespace Accelade\Widgets\Components;

use Closure;
use Illuminate\Support\Str;

/**
 * Table column definition for TableWidget.
 */
class Column
{
    protected string $name = '';

    protected ?string $label = null;

    protected bool $sortable = false;

    protected bool $searchable = false;

    protected ?string $alignment = null;

    protected ?Closure $formatStateUsing = null;

    protected ?string $url = null;

    protected bool $openUrlInNewTab = false;

    protected ?string $icon = null;

    protected ?string $iconPosition = null;

    protected ?string $color = null;

    protected ?Closure $colorCallback = null;

    protected bool $isHidden = false;

    protected ?string $width = null;

    protected bool $wrap = false;

    protected array $extraAttributes = [];

    /**
     * Create a new column instance.
     */
    public static function make(string $name): static
    {
        $static = new static;
        $static->name = $name;

        return $static;
    }

    /**
     * Get the column name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the label.
     */
    public function label(?string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get the label.
     */
    public function getLabel(): string
    {
        return $this->label ?? Str::headline($this->name);
    }

    /**
     * Enable sorting.
     */
    public function sortable(bool $condition = true): static
    {
        $this->sortable = $condition;

        return $this;
    }

    /**
     * Check if sortable.
     */
    public function isSortable(): bool
    {
        return $this->sortable;
    }

    /**
     * Enable searching.
     */
    public function searchable(bool $condition = true): static
    {
        $this->searchable = $condition;

        return $this;
    }

    /**
     * Check if searchable.
     */
    public function isSearchable(): bool
    {
        return $this->searchable;
    }

    /**
     * Set alignment.
     */
    public function alignment(string $alignment): static
    {
        $this->alignment = $alignment;

        return $this;
    }

    /**
     * Align left.
     */
    public function alignLeft(): static
    {
        return $this->alignment('left');
    }

    /**
     * Align center.
     */
    public function alignCenter(): static
    {
        return $this->alignment('center');
    }

    /**
     * Align right.
     */
    public function alignRight(): static
    {
        return $this->alignment('right');
    }

    /**
     * Get the alignment.
     */
    public function getAlignment(): ?string
    {
        return $this->alignment;
    }

    /**
     * Set a formatter for the state.
     */
    public function formatStateUsing(?Closure $callback): static
    {
        $this->formatStateUsing = $callback;

        return $this;
    }

    /**
     * Get the formatted state for a record.
     */
    public function getState(mixed $record): mixed
    {
        $value = data_get($record, $this->name);

        if ($this->formatStateUsing !== null) {
            return ($this->formatStateUsing)($value, $record);
        }

        return $value;
    }

    /**
     * Set an icon.
     */
    public function icon(?string $icon, string $position = 'before'): static
    {
        $this->icon = $icon;
        $this->iconPosition = $position;

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
     * Get the icon position.
     */
    public function getIconPosition(): ?string
    {
        return $this->iconPosition;
    }

    /**
     * Set a color.
     */
    public function color(string|Closure|null $color): static
    {
        if ($color instanceof Closure) {
            $this->colorCallback = $color;
        } else {
            $this->color = $color;
        }

        return $this;
    }

    /**
     * Get the color for a record.
     */
    public function getColor(mixed $record = null): ?string
    {
        if ($this->colorCallback !== null) {
            return ($this->colorCallback)(data_get($record, $this->name), $record);
        }

        return $this->color;
    }

    /**
     * Set visibility.
     */
    public function hidden(bool $condition = true): static
    {
        $this->isHidden = $condition;

        return $this;
    }

    /**
     * Check if hidden.
     */
    public function isHidden(): bool
    {
        return $this->isHidden;
    }

    /**
     * Set width.
     */
    public function width(?string $width): static
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get the width.
     */
    public function getWidth(): ?string
    {
        return $this->width;
    }

    /**
     * Enable text wrapping.
     */
    public function wrap(bool $condition = true): static
    {
        $this->wrap = $condition;

        return $this;
    }

    /**
     * Check if wrap enabled.
     */
    public function shouldWrap(): bool
    {
        return $this->wrap;
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
            'name' => $this->name,
            'label' => $this->getLabel(),
            'sortable' => $this->sortable,
            'searchable' => $this->searchable,
            'alignment' => $this->alignment,
            'hidden' => $this->isHidden,
            'width' => $this->width,
        ];
    }
}
