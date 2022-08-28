<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\ContainsNumber as NumbersRule;

class Numbers extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return NumbersRule::NAME;
    }
}
