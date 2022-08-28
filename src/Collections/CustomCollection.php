<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Collections;

use KrisKuiper\Validator\Blueprint\Custom\Custom;

class CustomCollection extends AbstractCollection
{
    /**
     * Constructor
     */
    public function __construct(Custom ...$customs)
    {
        parent::__construct($customs);
    }

    /**
     * @inheritdoc
     */
    public function current(): ?Custom
    {
        return ($item = current($this->items)) ? $item : null;
    }

    /**
     * Appends a new custom object to the collection
     */
    public function append(Custom $custom): void
    {
        $this->items[$custom->getRuleName()] = $custom;
    }

    public function getByRuleName(string $ruleName): ?Custom
    {
        return $this->items[$ruleName] ?? null;
    }
}
