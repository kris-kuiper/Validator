<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Negative as NegativeRule;

class Negative extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return NegativeRule::NAME;
    }
}
