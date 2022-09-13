<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

class ExcludeIf extends AbstractRequired
{
    public const NAME = 'excludeIf';

    /**
     * Constructor
     */
    public function __construct(private string|int|float $fieldName, private mixed $value)
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
     */
    public function isValid(): bool
    {
        $paths = $this->getPaths($this->fieldName);

        if (0 === $paths->count()) {
            return true;
        }

        foreach ($paths as $path) {
            if (null === $path) {
                continue;
            }

            if ($this->value === $path->getValue()) {
                $this->getField()?->setBailed(true);
                return true;
            }
        }

        return true;
    }
}
