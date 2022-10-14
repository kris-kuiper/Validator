<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Prohibits as ProhibitsRule;

class Prohibits extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return ProhibitsRule::NAME;
    }
}
