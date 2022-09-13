<?php

declare(strict_types=1);

namespace tests\unit\assets;

use KrisKuiper\Validator\Blueprint\Contracts\MiddlewareFieldInterface;
use KrisKuiper\Validator\Blueprint\Middleware\Transforms\AbstractMiddleware;

final class GetParametersMiddleware extends AbstractMiddleware
{
    public function handle(MiddlewareFieldInterface $field): void
    {
        if (['foo' => 'bar', 'quez' => 'bazz'] === $this->getParameters()) {
            $field->setValue($field->getFieldName());
        }
    }
}
