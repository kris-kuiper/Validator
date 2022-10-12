<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class SameNot extends AbstractRule
{
    public const NAME = 'sameNot';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Value may not be the same as :fieldName';

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
        $sameCount = 0;

        foreach ($fieldNames as $fieldName) {
            $paths = $this->getPaths($fieldName);

            foreach ($paths as $path) {
                if (null !== $path && $value === $path->getValue()) {
                    $sameCount++;
                }
            }

            if (null === $value && 0 === count($paths)) {
                $sameCount++;
            }
        }

        return (count($fieldNames) !== $sameCount);
    }
}
