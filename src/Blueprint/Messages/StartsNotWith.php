<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\StartsNotWith as StartsNotWithRule;

class StartsNotWith extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return StartsNotWithRule::NAME;
    }
}
