<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\EndsWith as EndsWithRule;

class EndsWith extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return EndsWithRule::NAME;
    }
}
