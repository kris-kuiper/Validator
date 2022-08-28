<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class MaxLength extends AbstractRule
{
    public const NAME = 'maxLength';

    /**
     * @inheritdocs
     */
    protected string $message = 'Value should not be longer than :characters characters';

    /**
     * Constructor
     */
    public function __construct(int $characters)
    {
        parent::__construct();
        $this->setParameter('characters', $characters);
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

        if (false === is_string($value) && false === is_numeric($value)) {
            return true;
        }

        return strlen((string) $value) <= $this->getParameter('characters');
    }
}
