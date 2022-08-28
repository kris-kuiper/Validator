<?php

declare(strict_types=1);

namespace tests\unit\assets;

use KrisKuiper\Validator\Blueprint\Contracts\MiddlewareFieldInterface;
use KrisKuiper\Validator\Blueprint\Middleware\Transforms\AbstractMiddleware;

final class LeadingZeroMiddleware extends AbstractMiddleware
{
    public function handle(MiddlewareFieldInterface $field): void
    {
        $value = $field->getValue();

        if (false === is_numeric($value)) {
            return;
        }

        $value = (float) $value;

        if ($value < 10 && $value >= 0) {
            $field->setValue('0' . $value);
        }
    }
}
