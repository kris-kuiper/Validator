<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Custom;

use KrisKuiper\Validator\Blueprint\Rules\AbstractRule;
use KrisKuiper\Validator\Storage\Storage;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class Current
{
    /**
     * Constructor
     */
    public function __construct(private AbstractRule $rule, private string $ruleName, private Storage $storage)
    {
    }

    /**
     * @throws ValidatorException
     */
    public function getParameter(string $parameterName): mixed
    {
        return $this->rule->getParameter($parameterName);
    }

    /**
     * Returns the parameters of the rule
     */
    public function getParameters(): array
    {
        return $this->rule->getParameters();
    }

    /**
     * @throws ValidatorException
     */
    public function getValue(string $fieldName = null): mixed
    {
        if (null === $fieldName) {
            return $this->rule->getValue();
        }

        return $this->rule->getValidationData()->path($fieldName)->getValue();
    }

    /**
     * Returns the name of the rule
     */
    public function getRuleName(): string
    {
        return $this->ruleName;
    }

    /**
     * Returns the data under validation as an array
     */
    public function getValidationData(): array
    {
        return $this->rule->getValidationData()->getData();
    }

    /**
     * Returns the name of the field under validation
     */
    public function getFieldName(): string|int|float|null
    {
        return $this->rule->getField()?->getFieldName();
    }

    /**
     * Sets custom error message for current rule and field
     */
    public function message(string $message): void
    {
        $fieldName = $this->getFieldName();

        if (null === $fieldName) {
            return;
        }

        $ruleName = $this->getRuleName();
        $this->rule->messages((string) $fieldName)->custom($ruleName, $message);
    }

    /**
     * Returns a storage object for storing/retrieving arbitrary data
     */
    public function storage(): Storage
    {
        return $this->storage;
    }

    public function field(string $fieldName): Validation
    {
        return new Validation($this->getValidationData(), $fieldName);
    }
}
