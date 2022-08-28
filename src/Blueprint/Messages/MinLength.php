<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\MinLength as MinLengthRule;

class MinLength extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return MinLengthRule::NAME;
    }
}
