<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Middleware\Transforms;

use KrisKuiper\Validator\Blueprint\Contracts\MiddlewareFieldInterface;
use KrisKuiper\Validator\Blueprint\Traits\DecimalTrait;

class ABS extends AbstractMiddleware
{
    use DecimalTrait;

    /**
     * @inheritdoc
     */
    public function handle(MiddlewareFieldInterface $field): void
    {
        $value = $field->getValue();
        $isString = true === is_string($value);

        if (false === is_numeric($value)) {
            return;
        }

        if (true === $this->isDecimal($value)) {
            $value = abs((float) $value);
        } else {
            $value = abs((int) $value);
        }

        if (true === $isString) {
            $value = (string) $value;
        }

        $field->setValue($value);
    }
}
