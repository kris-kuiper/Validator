<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Middleware\Transforms;

use KrisKuiper\Validator\Blueprint\Contracts\MiddlewareFieldInterface;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class Substr extends AbstractMiddleware
{
    /**
     * @inheritdoc
     * @throws ValidatorException
     */
    public function handle(MiddlewareFieldInterface $field): void
    {
        $value = $field->getValue();
        $offset = $this->getParameter('offset');
        $length = $this->getParameter('length');

        if (false === is_string($value)) {
            return;
        }

        $field->setValue(substr($value, $offset, $length));
    }
}
