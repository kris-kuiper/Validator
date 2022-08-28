<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint;

use KrisKuiper\Validator\Blueprint\Collections\MessageCollection;
use KrisKuiper\Validator\Blueprint\Contracts\MessageInterface;
use KrisKuiper\Validator\Blueprint\Traits\MessageTrait;

class MessageList
{
    use MessageTrait;

    private MessageCollection $messageCollection;

    public function __construct()
    {
        $this->messageCollection = new MessageCollection();
    }

    private function addMessage(MessageInterface $message): self
    {
        $this->messageCollection->append($message);
        return $this;
    }

    public function getMessageCollection(): MessageCollection
    {
        return $this->messageCollection;
    }
}
