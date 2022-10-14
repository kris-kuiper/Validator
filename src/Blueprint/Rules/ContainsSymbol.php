<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class ContainsSymbol extends AbstractRule
{
    public const NAME = 'containsSymbol';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Requires at least :symbolsCount symbol(s)';

    /**
     * Constructor
     */
    public function __construct(private int $minimumSymbolsCount = 1)
    {
        parent::__construct();
        $this->setParameter('symbolsCount', $minimumSymbolsCount);
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

        if (false === is_string($value)) {
            return false;
        }

        preg_match_all('/([\W_]+)/', preg_replace('/\s+/', '', $value), $matches);
        return count($matches[0] ?? []) >= $this->minimumSymbolsCount;
    }
}
