<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class ContainsDigit extends AbstractRule
{
    public const NAME = 'containsDigit';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Requires at least :digitCount digit(s)';

    /**
     * Constructor
     */
    public function __construct(private int $minimumDigitCount = 1)
    {
        parent::__construct();
        $this->setParameter('digitCount', $minimumDigitCount);
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

        preg_match_all('/(\d)/', (string) $value, $matches);
        return count($matches[0] ?? []) >= $this->minimumDigitCount;
    }
}
