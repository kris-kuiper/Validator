<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class DifferentWithAll extends AbstractRule
{
    public const NAME = 'different';

    /**
     * @inheritdoc
     */
    protected string $message = 'Value should be different than :fieldNames';

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
        $fieldNames = $this->getParameter('fieldNames');

        foreach ($fieldNames as $fieldName) {
            $paths = $this->getPaths($fieldName);

            foreach ($paths as $path) {
                if ($value === $path->getValue()) {
                    return false;
                }
            }
        }

        return true;
    }
}
