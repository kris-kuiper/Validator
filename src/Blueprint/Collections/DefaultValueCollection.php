<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Collections;

use KrisKuiper\Validator\Blueprint\DefaultValue;

class DefaultValueCollection extends AbstractCollection
{
    /**
     * Constructor
     */
    public function __construct(DefaultValue ...$defaultValues)
    {
        parent::__construct($defaultValues);
    }

    /**
     * @inheritdoc
     */
    public function current(): ?DefaultValue
    {
        return ($item = current($this->items)) ? $item : null;
    }

    /**
     * Appends a new defaultValue object to the collection
     */
    public function append(DefaultValue $defaultValue): void
    {
        $this->items[] = $defaultValue;
    }
}
