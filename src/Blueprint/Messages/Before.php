<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Before as BeforeRule;

class Before extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return BeforeRule::NAME;
    }
}
