<?php

declare(strict_types=1);

namespace Accelade\Widgets\Components;

use Accelade\Widgets\Widget;
use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Table widget for displaying tabular data.
 */
class TableWidget extends Widget
{
    protected string $heading = '';

    protected ?string $description = null;

    protected array $columns = [];

    protected Collection|LengthAwarePaginator|array|Closure $records = [];

    protected bool $striped = false;

    protected bool $hoverable = true;

    protected bool $bordered = false;

    protected bool $compact = false;

    protected ?string $emptyStateHeading = null;

    protected ?string $emptyStateDescription = null;

    protected ?string $emptyStateIcon = null;

    protected ?Closure $recordUrl = null;

    protected bool $paginated = false;

    protected int $perPage = 10;

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
     * Set the table columns.
     *
     * @param  array<Column>  $columns
     */
    public function columns(array $columns): static
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * Get the columns.
     *
     * @return array<Column>
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * Set the records/data.
     */
    public function records(Collection|LengthAwarePaginator|array|Closure $records): static
    {
        $this->records = $records;

        return $this;
    }

    /**
     * Get the records.
     */
    public function getRecords(): Collection|LengthAwarePaginator|array
    {
        $records = $this->evaluate($this->records);

        if (is_array($records)) {
            return collect($records);
        }

        return $records;
    }

    /**
     * Enable striped rows.
     */
    public function striped(bool $condition = true): static
    {
        $this->striped = $condition;

        return $this;
    }

    /**
     * Check if striped.
     */
    public function isStriped(): bool
    {
        return $this->striped;
    }

    /**
     * Enable row hover effect.
     */
    public function hoverable(bool $condition = true): static
    {
        $this->hoverable = $condition;

        return $this;
    }

    /**
     * Check if hoverable.
     */
    public function isHoverable(): bool
    {
        return $this->hoverable;
    }

    /**
     * Enable borders.
     */
    public function bordered(bool $condition = true): static
    {
        $this->bordered = $condition;

        return $this;
    }

    /**
     * Check if bordered.
     */
    public function isBordered(): bool
    {
        return $this->bordered;
    }

    /**
     * Enable compact mode.
     */
    public function compact(bool $condition = true): static
    {
        $this->compact = $condition;

        return $this;
    }

    /**
     * Check if compact.
     */
    public function isCompact(): bool
    {
        return $this->compact;
    }

    /**
     * Set empty state content.
     */
    public function emptyState(?string $heading = null, ?string $description = null, ?string $icon = null): static
    {
        $this->emptyStateHeading = $heading;
        $this->emptyStateDescription = $description;
        $this->emptyStateIcon = $icon;

        return $this;
    }

    /**
     * Get empty state heading.
     */
    public function getEmptyStateHeading(): ?string
    {
        return $this->emptyStateHeading ?? 'No records found';
    }

    /**
     * Get empty state description.
     */
    public function getEmptyStateDescription(): ?string
    {
        return $this->emptyStateDescription;
    }

    /**
     * Get empty state icon.
     */
    public function getEmptyStateIcon(): ?string
    {
        return $this->emptyStateIcon;
    }

    /**
     * Set the record URL callback.
     */
    public function recordUrl(?Closure $callback): static
    {
        $this->recordUrl = $callback;

        return $this;
    }

    /**
     * Get URL for a record.
     */
    public function getRecordUrl(mixed $record): ?string
    {
        if ($this->recordUrl === null) {
            return null;
        }

        return ($this->recordUrl)($record);
    }

    /**
     * Enable pagination.
     */
    public function paginated(bool $condition = true, int $perPage = 10): static
    {
        $this->paginated = $condition;
        $this->perPage = $perPage;

        return $this;
    }

    /**
     * Check if paginated.
     */
    public function isPaginated(): bool
    {
        return $this->paginated;
    }

    /**
     * Get per page.
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    protected function getView(): string
    {
        return 'widgets::components.table-widget';
    }

    protected function getViewData(): array
    {
        return [
            'widget' => $this,
            'heading' => $this->getHeading(),
            'description' => $this->getDescription(),
            'columns' => $this->getColumns(),
            'records' => $this->getRecords(),
        ];
    }
}
