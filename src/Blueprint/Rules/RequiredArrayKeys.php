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
    protected string|int|float $message = 'Should contain the keys ":keys"';

    /**
     * Constructor
     */
    public function __construct(string|int ...$keys)
    {
        parent::__construct();
        $this->setParameter('key', $keys);
        $this->setParameter('keys', implode(',', $keys));
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

        foreach ($this->getParameter('key') as $key) {
            if (false === array_key_exists($key, $value)) {
                return false;
            }
        }

        return true;
    }
}
