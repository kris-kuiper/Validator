<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Collections;

use KrisKuiper\Validator\Error;

class ErrorCollection extends AbstractCollection
{
    /**
     * Constructor
     */
    public function __construct(Error ...$errors)
    {
        parent::__construct($errors);
    }

    /**
     * @inheritdoc
     */
    public function current(): ?Error
    {
        return ($item = current($this->items)) ? $item : null;
    }

    /**
     * Appends a new error to the collection
     */
    public function append(Error $error): void
    {
        $this->items[] = $error;
    }

    /**
     * Returns a new collection with all the error object for a provided field name
     */
    public function get(string $fieldName): self
    {
        $collection = new self();

        /** @var Error $item */
        foreach ($this->items as $item) {
            if (false === $item->match($fieldName)) {
                continue;
            }

            $collection->append($item);
        }

        return $collection;
    }

    /**
     * Returns the first error object for a provided field name
     */
    public function first(string $fieldName): ?Error
    {
        return $this->get($fieldName)->current();
    }

    /**
     * Returns if a provided field name has errors or not
     */
    public function has(string $fieldName): bool
    {
        return null !== $this->get($fieldName)->current();
    }

    /**
     * Returns a new collection with all unique errors per field name
     */
    public function distinct(): self
    {
        $errors = [];

        /** @var Error $item */
        foreach ($this->items as $item) {
            $fieldName = $item->getFieldName();

            if (true === isset($errors[$fieldName ?? ''])) {
                continue;
            }

            $errors[$fieldName] = $item;
        }

        return new self(...$errors);
    }
}
