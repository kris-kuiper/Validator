<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Blueprint\Traits\WordTrait;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class MinWords extends AbstractRule
{
    use WordTrait;

    public const NAME = 'minWords';

    /**
     * @inheritdocs
     */
    protected string $message = 'Minimum of :words words required';

    /**
     * Constructor
     */
    public function __construct(int $words, int $minCharacters = 2, bool $onlyAlphanumeric = true)
    {
        parent::__construct();
        $this->setParameter('words', $words);
        $this->setParameter('minCharacters', $minCharacters);
        $this->setParameter('onlyAlphanumeric', $onlyAlphanumeric);
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
        $onlyAlphanumeric = $this->getParameter('onlyAlphanumeric');
        $minCharacters = $this->getParameter('minCharacters');
        $amount = $this->getParameter('words');

        if (false === is_string($value) && false === is_numeric($value)) {
            return false;
        }

        return count($this->filterWords($value, $minCharacters, $onlyAlphanumeric)) >= $amount;
    }
}
