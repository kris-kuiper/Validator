<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\ContainsNumber as ContainsNumberRule;

class ContainsNumber extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return ContainsNumberRule::NAME;
    }
}
