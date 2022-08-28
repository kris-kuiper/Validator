<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\NotContains as NotContainsRule;

class NotContains extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return NotContainsRule::NAME;
    }
}
