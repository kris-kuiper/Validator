<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class In extends AbstractRule
{
    public const NAME = 'in';

    /**
     * @inheritdoc
     */
    protected string $message = 'Invalid input';

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
        return true === in_array($this->getValue(), $this->getParameter('collection'), $this->getParameter('strict'));
    }
}
