<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class Regex extends AbstractRule
{
    public const NAME = 'regex';

    /**
     * @inheritdoc
     */
    protected string $message = 'Invalid input';

    /**
     * Constructor
     */
    public function __construct(private string $pattern)
    {
        parent::__construct();
        $this->setParameter('pattern', $pattern);
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

        return (bool) preg_match($this->pattern, (string) $value);
    }
}
