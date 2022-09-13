<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Collections;

use KrisKuiper\Validator\Combine\CombineProxy;

class CombineProxyCollection extends AbstractCollection
{
    /**
     * Constructor
     */
    public function __construct(CombineProxy ...$combines)
    {
        parent::__construct($combines);
    }

    /**
     * Returns the current element
     */
    public function current(): ?CombineProxy
    {
        return ($item = current($this->items)) ? $item : null;
    }

    /**
     * Appends the provided item to the collection
     */
    public function append(CombineProxy $combine): void
    {
        $this->items[] = $combine;
    }

    public function getByAlias(string|int $alias): ?CombineProxy
    {
        /** @var CombineProxy $item */
        foreach ($this->items as $item) {
            if ($alias === $item->getProxy()->getAlias()) {
                return $item;
            }
        }

        return null;
    }
}
