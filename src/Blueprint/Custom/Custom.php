<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Custom;

use Closure;

class Custom
{
    /**
     * Sets a callback function for validating the rule
     */
    public function __construct(private string $ruleName, private Closure $callback)
    {
    }

    /**
     * Returns the name of the custom rule
     */
    public function getRuleName(): string
    {
        return $this->ruleName;
    }

    /**
     * Returns the callback function
     */
    public function getCallback(): Closure
    {
        return $this->callback;
    }
}
