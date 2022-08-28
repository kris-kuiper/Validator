<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Collections;

use KrisKuiper\Validator\Blueprint\FieldOptions;

class FieldOptionCollection extends AbstractCollection
{
    /**
     * Constructor
     */
    public function __construct(FieldOptions ...$fieldOptions)
    {
        parent::__construct($fieldOptions);
    }

    /**
     * @inheritdoc
     */
    public function current(): ?FieldOptions
    {
        return ($item = current($this->items)) ? $item : null;
    }

    /**
     * Appends a new field options object to the collection
     */
    public function append(FieldOptions $fieldOptions): void
    {
        $this->items[] = $fieldOptions;
    }
}
