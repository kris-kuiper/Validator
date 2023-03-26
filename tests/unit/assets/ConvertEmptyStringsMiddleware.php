<?php

declare(strict_types=1);

namespace tests\unit\assets;

use KrisKuiper\Validator\Blueprint\Contracts\MiddlewareFieldInterface;
use KrisKuiper\Validator\Blueprint\Middleware\Transforms\AbstractMiddleware;

class ConvertEmptyStringsMiddleware extends AbstractMiddleware
{
    public function handle(MiddlewareFieldInterface $field): void
    {
        $value = $field->getValue();

        if('' !== $value){
            return;
        }

        $field->setValue(null);
    }
}
