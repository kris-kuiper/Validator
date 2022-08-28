<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class Equals extends AbstractRule
{
    public const NAME = 'equals';

    /**
     * @inheritdoc
     */
    protected string $message = 'Input should match :value';

    /**
     * Constructor
     */
    public function __construct($value, bool $strict = false)
    {
        parent::__construct();
        $this->setParameter('value', $value);
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
        $equals = $this->getParameter('value');

        //Check if strict mode is active
        if (true === $this->getParameter('strict')) {
            //Compare the two types
            if (gettype($value) !== gettype($equals)) {
                return false;
            }

            //Compare strictly
            return $value === $equals;
        }

        //Compare but not strictly
        // @codingStandardsIgnoreStart
        return $value == $equals;
        // @codingStandardsIgnoreEnd
    }
}
