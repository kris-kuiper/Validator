<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Collections;

use Closure;

class EventCollection extends AbstractCollection
{
    /**
     * Constructor
     */
    public function __construct(Closure ...$eventHandlers)
    {
        parent::__construct($eventHandlers);
    }

    /**
     * @inheritdoc
     */
    public function current(): ?Closure
    {
        return ($item = current($this->items)) ? $item : null;
    }

    /**
     * Appends a new event handler closure to the collection
     */
    public function append(Closure $eventHandler): void
    {
        $this->items[] = $eventHandler;
    }
}
