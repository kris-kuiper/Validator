<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Prohibited as ProhibitedRule;

class Prohibited extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return ProhibitedRule::NAME;
    }
}
