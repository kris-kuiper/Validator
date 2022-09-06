<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Timezone as TimezoneRule;

class Timezone extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return TimezoneRule::NAME;
    }
}
