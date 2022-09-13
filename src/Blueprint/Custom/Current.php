<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Custom;

use KrisKuiper\Validator\Blueprint\Rules\AbstractRule;
use KrisKuiper\Validator\Cache\Cache;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class Current
{
    /**
     * Constructor
     */
    public function __construct(private AbstractRule $rule, private string $ruleName, private Cache $cache)
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
     * Returns a caching object for storing/retrieving arbitrary data
     */
    public function cache(): Cache
    {
        return $this->cache;
    }
}
