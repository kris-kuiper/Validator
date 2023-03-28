<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class CSSColor extends AbstractRule
{
    public const NAME = 'cssColor';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Should be a valid CSS color';

    /**
     * Constructor
     */
    public function __construct(private bool $requireHash = false, private bool $shortcodesSupport = true)
    {
        parent::__construct();
        $this->setParameter('requireHash', $requireHash);
        $this->setParameter('shortcodesSupport', $shortcodesSupport);
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

        if (false === is_string($value)) {
            return false;
        }

        if(true === $this->requireHash && false === str_starts_with($value, '#')) {
            return false;
        }

        $value = preg_replace('/^#/', '', $value);
        $length = strlen($value);

        if(false === $this->shortcodesSupport && $length < 6) {
            return false;
        }

        if(6 !== $length && 3 !== $length) {
            return false;
        }

        return true === ctype_xdigit($value);
    }
}
