<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Middleware\Transforms;

use KrisKuiper\Validator\Blueprint\Contracts\MiddlewareFieldInterface;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use KrisKuiper\Validator\Helpers\ConvertEmpty;

class ConvertEmptyTo extends AbstractMiddleware
{
    /**
     * @inheritdoc
     * @throws ValidatorException
     */
    public function handle(MiddlewareFieldInterface $field): void
    {
        $value = $field->getValue();

        // Retrieve the parameters
        $convertTo = $this->getParameter('convertTo');
        $mode = $this->getParameter('mode');
        $recursive = $this->getParameter('recursive');

        //Convert and set the new value
        $convert = new ConvertEmpty($convertTo, $mode, $recursive);

        $field->setValue($convert->convert($value));
    }
}
