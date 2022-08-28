<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Middleware;

use KrisKuiper\Validator\Blueprint\Contracts\MiddlewareInterface;
use KrisKuiper\Validator\Blueprint\Middleware\Middleware;

class MiddlewareProxy
{
    /**
     * Constructor
     */
    public function __construct(private Middleware $middlewareProxy)
    {
    }

    /**
     * Creates the middleware blueprint and returns it
     */
    public function invoke(): MiddlewareInterface
    {
        $instance = $this->middlewareProxy->getInstance();
        $instance->setParameters($this->middlewareProxy->getParameters());

        return $instance;
    }
}
