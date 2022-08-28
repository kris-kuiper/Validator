<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Middleware\Transforms;

use KrisKuiper\Validator\Blueprint\Contracts\MiddlewareFieldInterface;

class LeadingZero extends AbstractMiddleware
{
    /**
     * @inheritdoc
     */
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
