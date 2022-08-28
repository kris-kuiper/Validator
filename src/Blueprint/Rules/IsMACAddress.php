<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class IsMACAddress extends AbstractRule
{
    public const NAME = 'IsMACAddress';

    /**
     * @inheritdocs
     */
    protected string $message = 'Value must be a valid MAC Address';

    /**
     * Constructor
     */
    public function __construct(string $delimiter = '-')
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
        $delimiter = $this->getParameter('delimiter');

        if (false === is_string($value) && false === is_numeric($value)) {
            return false;
        }

        return true === (bool) preg_match('/^([\dA-Fa-f]{2}[' . preg_quote($delimiter, '/') . ']){5}([\dA-Fa-f]{2})$/', (string) $value);
    }
}
