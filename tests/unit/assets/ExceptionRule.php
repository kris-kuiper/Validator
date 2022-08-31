<?php

declare(strict_types=1);

namespace tests\unit\assets;

use KrisKuiper\Validator\Blueprint\Rules\AbstractRule;

final class ExceptionRule extends AbstractRule
{
    public const NAME = 'ExceptionRule';

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @inheritdoc
     */
    public function isValid(): bool
    {
        return true;
    }
}
