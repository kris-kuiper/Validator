<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class NotIn extends AbstractRule
{
    public const NAME = 'notIn';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Invalid input';

    /**
     * Constructor
     */
    public function __construct(array $collection, bool $strict = false)
    {
        parent::__construct();
        $this->setParameter('collection', $collection);
        $this->setParameter('strict', $strict);
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
        return false === in_array($this->getValue(), $this->getParameter('collection'), $this->getParameter('strict'));
    }
}
