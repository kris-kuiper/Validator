<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Collections;

use KrisKuiper\Validator\Blueprint\Blueprint;

class BlueprintCollection extends AbstractCollection
{
    /**
     * Constructor
     */
    public function __construct(Blueprint ...$blueprints)
    {
        parent::__construct($blueprints);
    }

    /**
     * @inheritdoc
     */
    public function current(): ?Blueprint
    {
        return ($item = current($this->items)) ? $item : null;
    }

    /**
     * Appends a new blueprint object to the collection
     */
    public function append(Blueprint $blueprint): void
    {
        $this->items[] = $blueprint;
    }

    /**
     * Prepends a new blueprint object to the collection
     */
    public function prepend(Blueprint $blueprint): void
    {
        array_unshift($this->items, $blueprint);
    }
}
