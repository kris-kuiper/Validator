<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Between as BetweenRule;

class Between extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return BetweenRule::NAME;
    }
}
