<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class Required extends AbstractRequired
{
    public const NAME = 'required';

    /**
     * Constructor
     */
    public function __construct(bool $required = true)
    {
        parent::__construct();
        $this->setParameter('required', $required);
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
        $required = $this->getParameter('required');
        $empty = $this->isEmpty($this->getValue());

        if (false === $required) {
            if (true === $empty) {
                $this->getField()?->setBailed(true);
            }

            return true;
        }

        return false === $empty;
    }
}
