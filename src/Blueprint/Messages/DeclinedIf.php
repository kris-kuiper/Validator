<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\DeclinedIf as DeclinedIfRule;

class DeclinedIf extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return DeclinedIfRule::NAME;
    }
}
