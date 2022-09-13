<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class IsInt extends AbstractRule
{
    public const NAME = 'isInt';

    /**
     * @inheritdocs
     */
    protected string|int|float $message = 'Must be an integer number';

    /**
     * Constructor
     */
    public function __construct(bool $strict = false)
    {

        parent::__construct();
        $this->setParameter('strict', $strict);
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

        if (true !== is_string($value) && true !== is_numeric($value)) {
            return false;
        }

        if (true === $this->getParameter('strict')) {
            return true === is_int($value);
        }

        return true === (bool) preg_match('/^-?\d+$/', (string) $value);
    }
}
