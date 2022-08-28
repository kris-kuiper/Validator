<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class EndsWith extends AbstractRule
{
    public const NAME = 'endsWith';

    /**
     * @inheritdoc
     */
    protected string $message = 'Value must end with ":value"';

    /**
     * Constructor
     */
    public function __construct(string|int|float $value, bool $caseSensitive = false)
    {
        parent::__construct();
        $this->setParameter('value', $value);
        $this->setParameter('caseSensitive', $caseSensitive);
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
        $endsWith = $this->getParameter('value');

        if (false === is_string($value) && false === is_numeric($value)) {
            return false;
        }

        if (true === $this->getParameter('caseSensitive')) {
            return true === str_ends_with((string) $value, (string) $endsWith);
        }

        return true === str_ends_with(strtolower((string) $value), strtolower((string) $endsWith));
    }
}
