<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Contracts;

interface MessageInterface
{
    /**
     * Returns the message
     */
    public function getMessage(): string|int|float;

    /**
     * Returns the name of the rule
     */
    public function getName(): string;
}
