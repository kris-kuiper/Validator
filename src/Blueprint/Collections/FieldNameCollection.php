<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Collections;

use KrisKuiper\Validator\Blueprint\ValueObjects\FieldName;

class FieldNameCollection extends AbstractCollection
{
    /**
     * Constructor
     */
    public function __construct(FieldName ...$fieldNames)
    {
        parent::__construct([]);

        foreach ($fieldNames as $fieldName) {
            $this->set($fieldName);
        }
    }

    /**
     * @inheritdoc
     */
    public function current(): ?FieldName
    {
        return ($item = current($this->items)) ? $item : null;
    }

    /**
     * Appends a new fieldName object to the collection
     */
    public function set(FieldName $fieldName): void
    {
        $this->items[$fieldName->getFieldName()] = $fieldName;
    }

    /**
     * Returns a field name object based on the name of the field
     */
    public function get(string $fieldName): ?FieldName
    {
        return $this->items[$fieldName] ?? null;
    }
}
