<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Collections;

use KrisKuiper\Validator\Blueprint\Combine\Combine;

class CombineCollection extends AbstractCollection
{
    /**
     * Constructor
     */
    public function __construct(Combine ...$combines)
    {
        parent::__construct($combines);
    }

    /**
     * @inheritdoc
     */
    public function current(): ?Combine
    {
        return ($item = current($this->items)) ? $item : null;
    }

    /**
     * Appends a new combine object to the collection
     */
    public function append(Combine $combine): void
    {
        $this->items[] = $combine;
    }
}
