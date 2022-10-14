<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class RequiredArrayKeys extends AbstractRule
{
    public const NAME = 'requiredArrayKeys';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Minimum of :amount item(s)';

    /**
     * Constructor
     */
    public function __construct(string|int ...$keys)
    {
        parent::__construct();
        $this->setParameter('keys', $keys);
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

        if (false === is_array($value)) {
            return false;
        }

        foreach ($this->getParameter('keys') as $key) {
            if (false === array_key_exists($key, $value)) {
                return false;
            }
        }

        return true;
    }
}
