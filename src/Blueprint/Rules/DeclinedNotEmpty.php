<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Blueprint\Traits\EmptyTrait;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class DeclinedNotEmpty extends AbstractRule
{
    use EmptyTrait;

    public const NAME = 'declinedNotEmpty';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Should be declined';

    private array $declined = ['no', 'off', '0', 'false', 0, false];

    /**
     * Constructor
     */
    public function __construct(private string $fieldName, array $declined = [])
    {
        parent::__construct();

        if (0 !== count($declined)) {
            $this->declined = $declined;
        }

        $this->setParameter('fieldName', $this->fieldName);
        $this->setParameter('declined', $this->declined);
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
        $empty = $this->isEmpty($value);

        if (false === $empty) {
            return true === $this->isDeclined($value);
        }

        $paths = $this->getPaths($this->fieldName);

        foreach ($paths as $path) {
            if (false === $this->isEmpty($path?->getValue())) {
                return true === $this->isDeclined($value);
            }
        }

        return true === $this->isDeclined($value);
    }

    private function isDeclined(mixed $value): bool
    {
        return true === in_array($value, $this->declined, true);
    }
}
