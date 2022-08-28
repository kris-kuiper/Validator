<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Collections;

use KrisKuiper\Validator\Blueprint\Middleware\Middleware;

class MiddlewareCollection extends AbstractCollection
{
    /**
     * Constructor
     */
    public function __construct(Middleware ...$middlewares)
    {
        parent::__construct($middlewares);
    }

    /**
     * @inheritdoc
     */
    public function current(): ?Middleware
    {
        return ($item = current($this->items)) ? $item : null;
    }

    /**
     * Appends a new middleware object to the collection
     */
    public function append(Middleware $middleware): void
    {
        $this->items[] = $middleware;
    }
}
