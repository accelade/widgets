<?php

declare(strict_types=1);

namespace Accelade\Widgets;

use Accelade\Widgets\Contracts\Renderable;
use Closure;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Conditionable;

/**
 * Base widget class for dashboard components.
 */
abstract class Widget implements Renderable
{
    use Conditionable;

    protected string $id = '';

    protected string $name = '';

    protected int|string|Closure $columnSpan = 1;

    protected int|string|Closure $columnStart = 0;

    protected int $sort = 0;

    protected bool $isLazy = false;

    protected ?string $lazyPlaceholder = null;

    protected ?string $pollingInterval = null;

    protected bool $isVisible = true;

    protected array $extraAttributes = [];

    /**
     * Create a new widget instance.
     */
    public static function make(): static
    {
        $static = new static;
        $static->id = Str::slug(class_basename(static::class)).'-'.Str::random(8);
        $static->setUp();

        return $static;
    }

    /**
     * Set up the widget. Override in subclasses.
     */
    protected function setUp(): void
    {
        // Override in subclasses
    }

    /**
     * Set the widget ID.
     */
    public function id(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the widget ID.
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Set the widget name.
     */
    public function name(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the widget name (required by Renderable interface).
     */
    public function getName(): string
    {
        return $this->name !== '' ? $this->name : $this->id;
    }

    /**
     * Check if the widget is hidden (required by Renderable interface).
     */
    public function isHidden(): bool
    {
        return ! $this->isVisible;
    }

    /**
     * Set the column span for grid layout.
     *
     * @param  int|string|array<string, int>|Closure  $span
     */
    public function columnSpan(int|string|array|Closure $span): static
    {
        $this->columnSpan = $span;

        return $this;
    }

    /**
     * Make widget span full width.
     */
    public function columnSpanFull(): static
    {
        $this->columnSpan = 'full';

        return $this;
    }

    /**
     * Get the column span.
     */
    public function getColumnSpan(): int|string
    {
        return $this->evaluate($this->columnSpan);
    }

    /**
     * Set the column start position.
     */
    public function columnStart(int|string|Closure $start): static
    {
        $this->columnStart = $start;

        return $this;
    }

    /**
     * Get the column start.
     */
    public function getColumnStart(): int|string
    {
        return $this->evaluate($this->columnStart);
    }

    /**
     * Set the sort order.
     */
    public function sort(int $sort): static
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get the sort order.
     */
    public function getSort(): int
    {
        return $this->sort;
    }

    /**
     * Enable lazy loading.
     */
    public function lazy(bool $condition = true, ?string $placeholder = null): static
    {
        $this->isLazy = $condition;
        $this->lazyPlaceholder = $placeholder;

        return $this;
    }

    /**
     * Check if lazy loading is enabled.
     */
    public function isLazy(): bool
    {
        return $this->isLazy;
    }

    /**
     * Get the lazy placeholder.
     */
    public function getLazyPlaceholder(): ?string
    {
        return $this->lazyPlaceholder;
    }

    /**
     * Set polling interval for auto-refresh.
     */
    public function pollingInterval(?string $interval): static
    {
        $this->pollingInterval = $interval;

        return $this;
    }

    /**
     * Get the polling interval.
     */
    public function getPollingInterval(): ?string
    {
        return $this->pollingInterval;
    }

    /**
     * Set visibility.
     */
    public function visible(bool|Closure $condition = true): static
    {
        $this->isVisible = $this->evaluate($condition);

        return $this;
    }

    /**
     * Hide the widget.
     */
    public function hidden(bool|Closure $condition = true): static
    {
        $this->isVisible = ! $this->evaluate($condition);

        return $this;
    }

    /**
     * Check if visible.
     */
    public function isVisible(): bool
    {
        return $this->isVisible && $this->canView();
    }

    /**
     * Determine if the widget can be viewed.
     * Override in subclasses for authorization.
     */
    public function canView(): bool
    {
        return true;
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
     * Get extra attributes as HTML string.
     */
    public function getExtraAttributesString(): string
    {
        $html = [];

        foreach ($this->extraAttributes as $key => $value) {
            if (is_bool($value)) {
                if ($value) {
                    $html[] = e($key);
                }
            } else {
                $html[] = e($key).'="'.e($value).'"';
            }
        }

        return implode(' ', $html);
    }

    /**
     * Get the CSS classes for the widget container.
     */
    public function getContainerClasses(): string
    {
        $classes = ['widget'];

        $span = $this->getColumnSpan();
        if ($span === 'full') {
            $classes[] = 'col-span-full';
        } elseif (is_int($span)) {
            $classes[] = "col-span-{$span}";
        }

        $start = $this->getColumnStart();
        if ($start > 0) {
            $classes[] = "col-start-{$start}";
        }

        return implode(' ', $classes);
    }

    /**
     * Evaluate a value that may be a Closure.
     */
    protected function evaluate(mixed $value): mixed
    {
        if ($value instanceof Closure) {
            return $value();
        }

        return $value;
    }

    /**
     * Get the view name for this widget.
     */
    abstract protected function getView(): string;

    /**
     * Get the view data for rendering.
     */
    protected function getViewData(): array
    {
        return [
            'widget' => $this,
        ];
    }

    /**
     * Render the widget to HTML.
     */
    public function render(): string
    {
        if (! $this->isVisible()) {
            return '';
        }

        return view($this->getView(), $this->getViewData())->render();
    }

    /**
     * Get content as a string of HTML.
     */
    public function toHtml(): string
    {
        return $this->render();
    }

    /**
     * Convert widget to string.
     */
    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * Serialize to array for JSON output.
     */
    public function toArray(): array
    {
        return [
            'type' => class_basename(static::class),
            'id' => $this->id,
            'columnSpan' => $this->getColumnSpan(),
            'columnStart' => $this->getColumnStart(),
            'sort' => $this->sort,
            'lazy' => $this->isLazy,
            'pollingInterval' => $this->pollingInterval,
            'visible' => $this->isVisible(),
        ];
    }
}
