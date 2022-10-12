<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class Declined extends AbstractRule
{
    public const NAME = 'declined';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Should be declined';

    private array $declined = ['no', 'off', '0', 'false', 0, false];

    /**
     * Constructor
     */
    public function __construct(array $declined = [])
    {
        parent::__construct();

        if (0 !== count($declined)) {
            $this->declined = $declined;
        }

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
        return true === in_array($this->getValue(), $this->declined, true);
    }
}
