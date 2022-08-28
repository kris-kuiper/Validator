<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Collections;

use KrisKuiper\Validator\Fields\Field;
use KrisKuiper\Validator\Translator\Path;

class FieldCollection extends AbstractCollection
{
    /**
     * Constructor
     */
    public function __construct(Field ...$fieldNames)
    {
        parent::__construct($fieldNames);
    }

    /**
     * @inheritdoc
     */
    public function current(): ?Field
    {
        return ($item = current($this->items)) ? $item : null;
    }

    /**
     * Appends a new field object to the collection
     */
    public function append(Field $fieldName): void
    {
        $this->items[] = $fieldName;
    }

    /**
     * Returns a field object by matching a provided path object
     */
    public function getByPath(Path $path): ?Field
    {
        /** @var Field $item */
        foreach ($this->items as $item) {
            if ($item->getPath()->getIdentifier() === $path->getIdentifier()) {
                return $item;
            }
        }

        return null;
    }
}
