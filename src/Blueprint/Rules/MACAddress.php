<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class MACAddress extends AbstractRule
{
    public const NAME = 'macAddress';

    /**
     * @inheritdocs
     */
    protected string|int|float $message = 'Value must be a valid MAC Address';

    /**
     * Constructor
     */
    public function __construct(private string $delimiter = '-')
    {
        parent::__construct();
        $this->setParameter('delimiter', $delimiter);
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

        return true === (bool) preg_match('/^([\dA-Fa-f]{2}[' . preg_quote($this->delimiter, '/') . ']){5}([\dA-Fa-f]{2})$/', (string) $value);
    }
}
