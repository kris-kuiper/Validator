<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\StartsWith as StartsWithRule;

class StartsWith extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return StartsWithRule::NAME;
    }
}
