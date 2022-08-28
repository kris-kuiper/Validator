<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Middleware\Transforms;

use KrisKuiper\Validator\Blueprint\Contracts\MiddlewareFieldInterface;
use KrisKuiper\Validator\Blueprint\Traits\DecimalTrait;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class Round extends AbstractMiddleware
{
    use DecimalTrait;

    /**
     * @inheritdoc
     * @throws ValidatorException
     */
    public function handle(MiddlewareFieldInterface $field): void
    {
        $value = $field->getValue();
        $isString = true === is_string($value);
        $mode = $this->getParameter('mode');
        $precision = $this->getParameter('precision');

        if (false === is_numeric($value)) {
            return;
        }

        $value = round((float) $value, $precision, $mode);

        if (true === $isString) {
            $value = (string) $value;
        }

        $field->setValue($value);
    }
}
