<?php

declare(strict_types=1);

namespace tests\unit\assets;

use KrisKuiper\Validator\Blueprint\Contracts\MiddlewareFieldInterface;
use KrisKuiper\Validator\Blueprint\Middleware\Transforms\AbstractMiddleware;

final class BailMiddleware extends AbstractMiddleware
{
    public function handle(MiddlewareFieldInterface $field): void
    {
        $field->bail();
    }
}
