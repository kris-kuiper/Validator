<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Parser;

use KrisKuiper\Validator\Blueprint\Contracts\MessageInterface;

class Message
{
    private string $ruleName;
    private string|int|float $message;
    private string|int|float|null $fieldName;

    /**
     * Constructor
     */
    public function __construct(MessageInterface $message, string|int|float|null $fieldName = null)
    {
        $this->fieldName = $fieldName;
        $this->ruleName = $message->getName();
        $this->message = $message->getMessage();
    }

    /**
     * Returns the name of the field
     */
    public function getFieldName(): string|int|float|null
    {
        return $this->fieldName;
    }

    /**
     * Returns the name of the rule
     */
    public function getRuleName(): string
    {
        return $this->ruleName;
    }

    /**
     * Returns the error message
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
