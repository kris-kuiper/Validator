<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Contracts\MessageInterface;

abstract class AbstractMessage implements MessageInterface
{
    /**
     * Constructor
     */
    public function __construct(private string|int|float $message)
    {
    }

    /**
     * @inheritdoc
     */
    public function getMessage(): string|int|float
    {
        return $this->message;
    }

    /**
     * @inheritdoc
     */
    abstract public function getName(): string;
}
