<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\IsTimezone as IsTimezoneRule;

class IsTimezone extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return IsTimezoneRule::NAME;
    }
}
