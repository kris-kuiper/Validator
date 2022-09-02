<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Collections;

use KrisKuiper\Validator\Parser\Message;

class FieldMessageCollection extends AbstractCollection
{
    /**
     * Constructor
     */
    public function __construct(Message ...$messages)
    {
        parent::__construct($messages);
    }

    /**
     * @inheritdoc
     */
    public function current(): ?Message
    {
        return ($item = current($this->items)) ? $item : null;
    }

    /**
     * Appends a new field object to the collection
     */
    public function append(Message $message): void
    {
        $fieldName = $message->getFieldName();

        $this->items[$fieldName] ??= [];
        $this->items[$fieldName][$message->getRuleName()] = $message->getMessage();
    }
}
