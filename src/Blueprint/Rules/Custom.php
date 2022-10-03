<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use Closure;
use KrisKuiper\Validator\Blueprint\Events\Event;

class Custom extends AbstractRule
{
    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Invalid value';


    /**
     * Constructor
     */
    public function __construct(private string $name, private Closure $callback, array $parameters = [])
    {
        parent::__construct();

        foreach ($parameters as $parameterName => $value) {
            $this->setParameter($parameterName, $value);
        }
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets a new callback which should be executed on validation
     */
    public function setCallback(Closure $callback): void
    {
        $this->callback = $callback;
    }

    /**
     * @inheritdoc
     */
    public function isValid(): bool
    {
        $callback = $this->callback;
        return $callback(new Event($this, $this->getName(), $this->getStorage()));
    }
}
