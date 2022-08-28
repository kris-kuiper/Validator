<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Collections;

use KrisKuiper\Validator\Blueprint\Rules\AbstractRule;

class RuleCollection extends AbstractCollection
{
    /**
     * Constructor
     */
    public function __construct(AbstractRule ...$rules)
    {
        parent::__construct($rules);
    }

    /**
     * @inheritdoc
     */
    public function current(): ?AbstractRule
    {
        return ($item = current($this->items)) ? $item : null;
    }

    /**
     * Appends a new rule object to the collection
     */
    public function append(AbstractRule $rule): void
    {
        $this->items[] = $rule;
    }
}
