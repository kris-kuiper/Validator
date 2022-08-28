<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Middleware\Transforms;

use KrisKuiper\Validator\Blueprint\Contracts\MiddlewareFieldInterface;

class ToString extends AbstractMiddleware
{
    /**
     * @inheritdoc
     */
    public function handle(MiddlewareFieldInterface $field): void
    {
        $value = $field->getValue();

        if (false === is_scalar($value)) {
            $value = '';
        }

        $field->setValue((string) $value);
    }
}
