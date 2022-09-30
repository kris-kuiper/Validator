<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Custom;

use KrisKuiper\Validator\Blueprint\Collections\RuleCollection;
use KrisKuiper\Validator\Blueprint\Rules\AbstractRule;
use KrisKuiper\Validator\Blueprint\Traits\RuleTrait;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use KrisKuiper\Validator\Validator;

class Validation
{
    use RuleTrait;

    private RuleCollection $ruleCollection;
    private Validator $validator;

    /**
     * Constructor
     */
    public function __construct(array $validationData, private string $fieldName)
    {
        $this->ruleCollection = new RuleCollection();
        $this->validator = new Validator($validationData);
    }

    /**
     * Checks if validation passes
     * @throws ValidatorException
     */
    public function isValid(): bool
    {
        $field = $this->validator->field($this->fieldName);

        foreach ($this->ruleCollection as $rule) {
            if (null === $rule) {
                continue;
            }

            $field->{$rule->getName()}(...$rule->getParameters());
        }

        return $this->validator->passes();
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
