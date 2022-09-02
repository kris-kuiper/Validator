<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Collections;

use Countable;
use Iterator;

abstract class AbstractCollection implements Iterator, Countable
{
    /**
     * Contains all the elements in the collection as an internal array
     */
    protected array $items = [];

    /**
     * Constructor
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * Returns the key of the current item
     */
    public function key(): string|int|float|null
    {
        return key($this->items);
    }

    /**
     * Returns the array value in the next place that's pointed to by the internal array pointer, or false if there are no more elements
     */
    public function next(): void
    {
        next($this->items);
    }

    /**
     * Returns if the current position is valid
     */
    public function valid(): bool
    {
        return null !== $this->key();
    }

    /**
     * Rewinds the Iterator to the first element
     */
    public function rewind(): void
    {
        reset($this->items);
    }

    /**
     * Reverts the order of the items
     */
    public function reverse(): self
    {
        $this->items = array_reverse($this->items);
        return $this;
    }

    /**
     * Returns all the items in the iterator as an array
     */
    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * Returns the amount of items stored in the iterator
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * Loops through all the items in the iterator and executes a user defined callback function with the key and value as injected parameters
     * If the user defined callback function returns false, the loop will break
     */
    public function each(callable $callback): void
    {
        foreach ($this->items as $key => $item) {
            if (false === $callback($item, $key)) {
                break;
            }
        }
    }
}
