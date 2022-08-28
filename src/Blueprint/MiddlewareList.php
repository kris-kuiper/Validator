<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint;

use KrisKuiper\Validator\Blueprint\Collections\MiddlewareCollection;
use KrisKuiper\Validator\Blueprint\Contracts\MiddlewareInterface;
use KrisKuiper\Validator\Blueprint\Middleware\Middleware;
use KrisKuiper\Validator\Blueprint\Traits\TransformTrait;

class MiddlewareList
{
    use TransformTrait;

    private MiddlewareCollection $middlewareCollection;

    public function __construct()
    {
        $this->middlewareCollection = new MiddlewareCollection();
    }

    public function getMiddlewareCollection(): MiddlewareCollection
    {
        return $this->middlewareCollection;
    }

    public function load(MiddlewareInterface $middleware, array $parameters = []): self
    {
        return $this->addTransform($middleware, $parameters);
    }

    /**
     * Adds a new transform middleware to the collection
     */
    private function addTransform(MiddlewareInterface $middleware, array $parameters = []): self
    {
        $this->middlewareCollection->append(new Middleware($middleware, $parameters));
        return $this;
    }
}
