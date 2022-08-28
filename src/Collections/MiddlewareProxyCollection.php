<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Collections;

use KrisKuiper\Validator\Middleware\MiddlewareProxy;

class MiddlewareProxyCollection extends AbstractCollection
{
    /**
     * Constructor
     */
    public function __construct(MiddlewareProxy ...$middlewares)
    {
        parent::__construct($middlewares);
    }

    /**
     * @inheritdoc
     */
    public function current(): ?MiddlewareProxy
    {
        return ($item = current($this->items)) ? $item : null;
    }

    /**
     * Appends a new middleware object to the collection
     */
    public function append(MiddlewareProxy $middleware): void
    {
        $this->items[] = $middleware;
    }
}
