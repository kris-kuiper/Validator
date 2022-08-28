<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Collections;

use KrisKuiper\Validator\Blueprint\MiddlewareList;

class MiddlewareListCollection extends AbstractCollection
{
    /**
     * Constructor
     */
    public function __construct(MiddlewareList ...$middlewareLists)
    {
        parent::__construct($middlewareLists);
    }

    /**
     * @inheritdoc
     */
    public function current(): ?MiddlewareList
    {
        return ($item = current($this->items)) ? $item : null;
    }

    /**
     * Appends a new middleware list object to the collection
     */
    public function append(MiddlewareList $middlewareList): void
    {
        $this->items[] = $middlewareList;
    }
}
