<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\RequiredWith as RequiredWithRule;

class RequiredWith extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return RequiredWithRule::NAME;
    }
}
