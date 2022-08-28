<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class ExcludeIf extends AbstractRequired
{
    public const NAME = 'excludeIf';

    /**
     * Constructor
     */
    public function __construct(string|int|float $fieldName, mixed $value)
    {
        $this->setParameter('fieldName', $fieldName);
        $this->setParameter('value', $value);
        parent::__construct();
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
        $fieldName = $this->getParameter('fieldName');
        $value = $this->getParameter('value');
        $paths = $this->getPaths($fieldName);

        if (0 === $paths->count()) {
            return true;
        }

        foreach ($paths as $path) {
            if ($value === $path->getValue()) {
                $this->getField()?->setBailed(true);
                return true;
            }
        }

        return true;
    }
}
