<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Middleware\Transforms;

use KrisKuiper\Validator\Blueprint\Contracts\MiddlewareFieldInterface;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class Trim extends AbstractMiddleware
{
    /**
     * @inheritdoc
     * @throws ValidatorException
     */
    public function handle(MiddlewareFieldInterface $field): void
    {
        $value = $field->getValue();
        $characters = $this->getParameter('characters');

        if (false === is_string($value)) {
            return;
        }

        $field->setValue(trim($value, $characters));
    }
}
