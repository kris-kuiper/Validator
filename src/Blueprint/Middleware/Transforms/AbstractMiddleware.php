<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Middleware\Transforms;

use KrisKuiper\Validator\Blueprint\Contracts\MiddlewareInterface;
use KrisKuiper\Validator\Exceptions\ValidatorException;

abstract class AbstractMiddleware implements MiddlewareInterface
{
    private array $parameters = [];

    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @throws ValidatorException
     */
    public function getParameter(string|int $name): mixed
    {
        return array_key_exists($name, $this->parameters) ? $this->parameters[$name] : throw ValidatorException::parameterNotFound($name);
    }
}
