<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\IsNotNull as IsNotNullRule;

class IsNotNull extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return IsNotNullRule::NAME;
    }
}
