<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\IsNull as IsNullRule;

class IsNull extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return IsNullRule::NAME;
    }
}
