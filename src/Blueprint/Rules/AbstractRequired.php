<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Blueprint\Traits\EmptyTrait;

abstract class AbstractRequired extends AbstractRule
{
    use EmptyTrait;

    /**
     * @inheritdoc
     */
    protected bool $bail = true;

    /**
     * Contains the error message
     */
    protected string|int|float $message = 'Field is required';
}
