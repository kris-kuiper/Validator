<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

class Custom extends AbstractMessage
{
    /**
     * Constructor
     */
    public function __construct(private string $ruleName, string|int|float $message)
    {
        parent::__construct($message);
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return $this->ruleName;
    }
}
