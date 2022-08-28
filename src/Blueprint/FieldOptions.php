<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint;

use Closure;
use KrisKuiper\Validator\Blueprint\Collections\RuleCollection;
use KrisKuiper\Validator\Blueprint\Rules\AbstractRule;
use KrisKuiper\Validator\Blueprint\Rules\Conditional;
use KrisKuiper\Validator\Blueprint\Rules\ExcludeIf;
use KrisKuiper\Validator\Blueprint\Traits\RuleTrait;

class FieldOptions
{
    use RuleTrait;

    /**
     * Contains if a single rule should prevent executing the upcoming rules if validation for this rule fails
     */
    private ?bool $bail = null;

    private RuleCollection $ruleCollection;

    public function __construct()
    {
        $this->ruleCollection = new RuleCollection();
    }

    public function getRules(): RuleCollection
    {
        return $this->ruleCollection;
    }

    /**
     * Returns if the
     */
    public function getBail(): ?bool
    {
        return $this->bail;
    }

    /**
     * Sets if a single rule should prevent executing the upcoming rules if validation for this rule fails
     */
    public function bail(bool $bail = true): self
    {
        $this->bail = $bail;
        return $this;
    }

    /**
     * Adds a new condition to skip validation when fields have certain values
     */
    public function conditional(Closure $callback): self
    {
        return $this->addRule(new Conditional($callback));
    }

    /**
     * Adds a new condition to skip validation if another field has a given value
     */
    public function excludeIf(string|int|float $fieldName, mixed $value): self
    {
        return $this->addRule(new ExcludeIf($fieldName, $value));
    }

    /**
     * Adds a new rule to the collection
     */
    private function addRule(AbstractRule $rule): self
    {
        $this->ruleCollection->append($rule);
        return $this;
    }
}
