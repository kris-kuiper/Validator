<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Collections;

use KrisKuiper\Validator\Translator\Path;

class PathCollection extends AbstractCollection
{
    /**
     * Constructor
     */
    public function __construct(Path ...$paths)
    {
        parent::__construct($paths);
    }

    /**
     * @inheritdoc
     */
    public function current(): ?Path
    {
        return ($item = current($this->items)) ? $item : null;
    }

    /**
     * Appends a new path object to the collection
     */
    public function append(Path $path): void
    {
        $this->items[] = $path;
    }

    /**
     * Returns the values of all the path objects in the collections as an array
     */
    public function getValues(): array
    {
        $output = [];

        /** @var Path $item */
        foreach ($this->items as $item) {
            $output[] = $item->getValue();
        }

        return $output;
    }

    /**
     * Returns the value
     */
    public function getValue(): mixed
    {
        $output = $this->getValues();
        return count($output) > 1 ? $output : ($output[0] ?? null);
    }
}
