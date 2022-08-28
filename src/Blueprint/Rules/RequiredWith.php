<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class RequiredWith extends AbstractRequired
{
    public const NAME = 'requiredWith';

    /**
     * Constructor
     */
    public function __construct(string ...$fieldNames)
    {
        parent::__construct();
        $this->setParameter('fieldNames', $fieldNames);
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return static::NAME;
    }

    /**
     * @inheritdoc
     * @throws ValidatorException
     */
    public function isValid(): bool
    {
        $value = $this->getValue();
        $empty = $this->isEmpty($value);

        if (false === $empty) {
            return true;
        }

        $fieldNames = $this->getParameter('fieldNames');

        foreach ($fieldNames as $fieldName) {
            $paths = $this->getPaths($fieldName);

            foreach ($paths as $path) {
                if (false === $this->isEmpty($path->getValue())) {
                    return false;
                }
            }
        }

        return true;
    }
}
