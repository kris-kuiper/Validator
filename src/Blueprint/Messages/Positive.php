<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Positive as PositiveRule;

class Positive extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return PositiveRule::NAME;
    }
}
