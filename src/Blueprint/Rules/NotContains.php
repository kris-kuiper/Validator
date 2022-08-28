<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Collections\CombineProxyCollection;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use KrisKuiper\Validator\Fields\Field;
use KrisKuiper\Validator\Translator\Path;

class NotContains extends AbstractRule
{
    public const NAME = 'notContains';
/**
     * @inheritdoc
     */
    protected string $message = 'Value may not contain ":value"';
/**
     * Constructor
     */
    public function __construct(string|int|float $value, bool $caseSensitive = false)
    {
        parent::__construct();
        $this->setParameter('value', $value);
        $this->setParameter('caseSensitive', $caseSensitive);
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
        $field = new Field(new Path(['value'], $value), 'value', new CombineProxyCollection());

        $contains = new Contains($this->getParameter('value'), $this->getParameter('caseSensitive'));
        $contains->setField($field);

        return false === $contains->isValid();
    }
}
