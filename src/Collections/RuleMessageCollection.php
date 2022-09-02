<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Collections;

use KrisKuiper\Validator\Parser\Message;

class RuleMessageCollection extends AbstractCollection
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
        $this->items[$message->getRuleName()] = $message;
    }

    public function filterByName(string $name): ?Message
    {
        foreach ($this->items as $ruleName => $item) {
            if ($ruleName === $name) {
                return $item;
            }
        }

        return null;
    }
}
