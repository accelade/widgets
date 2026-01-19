<?php

declare(strict_types=1);

namespace Accelade\Widgets\Contracts;

use Illuminate\Contracts\Support\Htmlable;

/**
 * Contract for widgets that can be rendered.
 */
interface Renderable extends Htmlable
{
    /**
     * Get the widget name.
     */
    public function getName(): string;

    /**
     * Check if the widget is hidden.
     */
    public function isHidden(): bool;
}
