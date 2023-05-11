<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class RequiredWithout extends AbstractRequired
{
    public const NAME = 'requiredWithout';

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

            if (0 === $paths->count()) {
                return false;
            }

            foreach ($paths as $path) {
                if (null !== $path && true === $this->isEmpty($path->getValue())) {
                    return false;
                }
            }
        }

        $this->getField()?->setBailed(true);

        return true;
    }
}
