<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Number as NumberRule;

class Number extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return NumberRule::NAME;
    }
}
