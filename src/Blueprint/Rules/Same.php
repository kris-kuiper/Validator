<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class Same extends AbstractRule
{
    public const NAME = 'same';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Value should be the same as :fieldName';

    /**
     * Constructor
     */
    public function __construct(string ...$fieldNames)
    {
        parent::__construct();
        $this->setParameter('fieldName', implode(', ', $fieldNames));
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

            foreach ($paths as $path) {
                if (null === $path) {
                    return false;
                }

                if ($value !== $path->getValue()) {
                    return false;
                }
            }

            if (0 === count($paths)) {
                return null === $value;
            }
        }

        return true;
    }
}
