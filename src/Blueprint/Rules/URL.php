<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class URL extends AbstractRule
{
    public const NAME = 'url';

    /**
     * @inheritdocs
     */
    protected string|int|float $message = 'Value should be a valid URL';

    /**
     * Constructor
     */
    public function __construct(private bool $protocol = true)
    {
        parent::__construct();
        $this->setParameter('protocol', $protocol);
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

        if (true === is_string($value)) {
            if (false === $this->protocol) {
                $value = preg_replace('/^http(s)?:\/\//i', '', $value);
                $value = 'http://' . $value;
            }

            return true === (bool) preg_match('%^(?:https?|ftp)://(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*\.[a-z\x{00a1}-\x{ffff}]{2,6})(?::\d+)?(?:\S*)?$%iu', $value);
        }

        return false;
    }
}
