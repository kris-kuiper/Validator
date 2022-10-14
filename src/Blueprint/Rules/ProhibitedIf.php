<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Blueprint\Traits\EmptyTrait;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class ProhibitedIf extends AbstractRule
{
    use EmptyTrait;

    public const NAME = 'prohibitedIf';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Invalid input';

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
        $fieldNames = $this->getParameter('fieldNames');
        $value = $this->getValue();

        if (true === $this->isEmpty($value)) {
            return true;
        }

        foreach ($fieldNames as $fieldName) {
            $paths = $this->getPaths($fieldName);

            if (0 === count($paths)) {
                return true;
            }

            foreach ($paths as $path) {
                if (null === $path || true === $this->isEmpty($path->getValue())) {
                    return true;
                }
            }
        }

        return 0 === count($fieldNames);
    }
}
