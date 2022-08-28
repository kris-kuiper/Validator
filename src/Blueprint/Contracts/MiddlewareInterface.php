<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Contracts;

interface MiddlewareInterface
{
    /**
     * Sets the handler which will be triggered to execute the middleware
     */
    public function handle(MiddlewareFieldInterface $field): void;

    /**
     * Sets the parameters which can be summoned during the executing of the middleware
     */
    public function setParameters(array $parameters): void;

    /**
     * Returns the parameters which can be summoned during the executing of the middleware
     */
    public function getParameters(): array;
}
