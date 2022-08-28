<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\ValueObjects;

use KrisKuiper\Validator\Blueprint\Collections\MessageListCollection;
use KrisKuiper\Validator\Blueprint\Collections\FieldOptionCollection;
use KrisKuiper\Validator\Blueprint\Collections\MiddlewareListCollection;

class FieldName
{
    private FieldOptionCollection $fieldOptions;
    private MessageListCollection $messages;
    private MiddlewareListCollection $middleware;

    /**
     * Constructor
     */
    public function __construct(private string $fieldName)
    {
        $this->fieldOptions = new FieldOptionCollection();
        $this->messages = new MessageListCollection();
        $this->middleware = new MiddlewareListCollection();
    }

    /**
     * Returns the field name
     */
    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    /**
     * Returns all the field options
     */
    public function getFieldOptions(): FieldOptionCollection
    {
        return $this->fieldOptions;
    }

    /**
     * Returns all the field messages
     */
    public function getMessageLists(): MessageListCollection
    {
        return $this->messages;
    }

    /**
     * Returns all the field middleware
     */
    public function getMiddlewareLists(): MiddlewareListCollection
    {
        return $this->middleware;
    }
}
