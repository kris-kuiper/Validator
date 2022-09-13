<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class Different extends AbstractRule
{
    public const NAME = 'different';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Value should be different than :fieldNames';

    /**
     * Constructor
     */
    public function __construct(string|int|float ...$fieldNames)
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
        $fieldNames = $this->getParameter('fieldNames');

        foreach ($fieldNames as $fieldName) {
            $paths = $this->getPaths($fieldName);

            if (0 === $paths->count()) {
                return true;
            }

            foreach ($paths as $path) {
                if (null === $path) {
                    if (null !== $value) {
                        return true;
                    }

                    continue;
                }

                if ($value !== $path->getValue()) {
                    return true;
                }
            }
        }

        return false;
    }
}
