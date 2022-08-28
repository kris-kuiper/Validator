<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Middleware;

use KrisKuiper\Validator\Blueprint\Contracts\MiddlewareInterface;

class Middleware
{
    /**
     * Constructor
     */
    public function __construct(private MiddlewareInterface $middleware, private array $parameters = [])
    {
    }

    /**
     * Returns the instance (the class which implements the Middleware Interface)
     */
    public function getInstance(): MiddlewareInterface
    {
        return $this->middleware;
    }

    /**
     * Returns the parameters
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }
}
