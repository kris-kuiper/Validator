<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class ContainsLetter extends AbstractRule
{
    public const NAME = 'containsLetter';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Requires at least :letterCount letter(s)';

    /**
     * Constructor
     */
    public function __construct(private int $minimumLetterCount = 1)
    {
        parent::__construct();
        $this->setParameter('letterCount', $minimumLetterCount);
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

        preg_match_all('/([a-zA-Z])/', $value, $matches);
        return count($matches[0] ?? []) >= $this->minimumLetterCount;
    }
}
