<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class DeclinedIf extends AbstractRule
{
    public const NAME = 'declinedIf';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Should be declined';

    private array $declined = ['no', 'off', '0', 'false', 0, false];

    /**
     * Constructor
     */
    public function __construct(private string $fieldName, private mixed $value, array $declined = [])
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
        $declined = $this->getValue();
        $targetValue = $this->getValidationData()->path($this->fieldName)->getValue();

        if ($this->value === $targetValue) {
            return true === in_array($declined, $this->declined, true);
        }

        return true;
    }
}
