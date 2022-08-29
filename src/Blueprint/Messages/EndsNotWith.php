<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\EndsNotWith as EndsNotWithRule;

class EndsNotWith extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return EndsNotWithRule::NAME;
    }
}
