<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Collections;

use KrisKuiper\Validator\Blueprint\Contracts\MessageInterface;

class MessageCollection extends AbstractCollection
{
    /**
     * Constructor
     */
    public function __construct(MessageInterface ...$messages)
    {
        parent::__construct($messages);
    }

    /**
     * @inheritdoc
     */
    public function current(): ?MessageInterface
    {
        return ($item = current($this->items)) ? $item : null;
    }

    /**
     * Appends a new message object to the collection
     */
    public function append(MessageInterface $message): void
    {
        $this->items[$message::class] = $message;
    }
}
