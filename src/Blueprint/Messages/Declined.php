<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Declined as DeclinedRule;

class Declined extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return DeclinedRule::NAME;
    }
}
