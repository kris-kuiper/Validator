<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Middleware\Transforms;

use KrisKuiper\Validator\Blueprint\Contracts\MiddlewareFieldInterface;
use KrisKuiper\Validator\Blueprint\Traits\DecimalTrait;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class Replace extends AbstractMiddleware
{
    use DecimalTrait;

    /**
     * @inheritdoc
     * @throws ValidatorException
     */
    public function handle(MiddlewareFieldInterface $field): void
    {
        $value = $field->getValue();
        $search = $this->getParameter('search');
        $replace = $this->getParameter('replace');

        if (false === is_string($value) && false === is_numeric($value)) {
            return;
        }

        if (false === is_string($value)) {
            if (true === $this->isDecimal($value)) {
                $value = (float) str_replace($search, $replace, (string) $value);
            } else {
                $value = (int) str_replace($search, $replace, (string) $value);
            }
        } else {
            $value = str_replace($search, $replace, $value);
        }

        $field->setValue($value);
    }
}
