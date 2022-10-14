<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Confirmed as ConfirmedRule;

class Confirmed extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return ConfirmedRule::NAME;
    }
}
