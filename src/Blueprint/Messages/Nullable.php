<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Nullable as NullableRule;

class Nullable extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return NullableRule::NAME;
    }
}
