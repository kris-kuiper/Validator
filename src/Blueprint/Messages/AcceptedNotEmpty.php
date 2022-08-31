<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\AcceptedNotEmpty as AcceptedNotEmptyRule;

class AcceptedNotEmpty extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return AcceptedNotEmptyRule::NAME;
    }
}
