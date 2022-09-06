<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Accepted as AcceptedRule;

class Accepted extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return AcceptedRule::NAME;
    }
}
