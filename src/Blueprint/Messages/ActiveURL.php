<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\ActiveURL as ActiveURLRule;

class ActiveURL extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return ActiveURLRule::NAME;
    }
}
