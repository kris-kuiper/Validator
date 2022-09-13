<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use Closure;
use KrisKuiper\Validator\Blueprint\Custom\Current;

class Conditional extends AbstractRule
{
    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Invalid value';

    /**
     * Constructor
     */
    public function __construct(private Closure $callback)
    {
        parent::__construct();
        $this->setParameter('callback', $callback);
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return 'conditional';
    }

    /**
     * @inheritdoc
     */
    public function isValid(): bool
    {
        $callback = $this->callback;
        $conditional = $callback(new Current($this, $this->getName(), $this->getCache()));

        if (false === $conditional) {
            $this->getField()?->setBailed(true);
        }

        return true;
    }
}
