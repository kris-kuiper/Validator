<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class RequiredWithoutAll extends AbstractRequired
{
    public const NAME = 'requiredWithoutAll';

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
        $result = [];

        foreach ($fieldNames as $fieldName) {
            $paths = $this->getPaths($fieldName);

            if (0 === $paths->count()) {
                $result[] = null;
            }

            foreach ($paths as $path) {
                if (null !== $path && true === $this->isEmpty($path->getValue())) {
                    $result[] = null;
                    continue;
                }

                $result[] = true;
            }
        }

        $emptyAmount = count(array_filter($result));

        if (0 !== $emptyAmount) {
            $this->getField()?->setBailed(true);
            return true;
        }

        return false;
    }
}
