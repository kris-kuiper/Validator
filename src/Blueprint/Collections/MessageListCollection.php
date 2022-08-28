<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Collections;

use KrisKuiper\Validator\Blueprint\MessageList;

class MessageListCollection extends AbstractCollection
{
    /**
     * Constructor
     */
    public function __construct(MessageList ...$messageLists)
    {
        parent::__construct($messageLists);
    }

    /**
     * @inheritdoc
     */
    public function current(): ?MessageList
    {
        return ($item = current($this->items)) ? $item : null;
    }

    /**
     * Appends a new message list object to the collection
     */
    public function append(MessageList $messageList): void
    {
        $this->items[] = $messageList;
    }
}
