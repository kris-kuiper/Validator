<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class LengthMin extends AbstractRule
{
    public const NAME = 'lengthMin';

    /**
     * @inheritdocs
     */
    protected string $message = 'Value should have at least :characters characters';

    /**
     * Constructor
     */
    public function __construct(private int $characters)
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
            return false;
        }

        return strlen((string) $value) >= $this->characters;
    }
}
