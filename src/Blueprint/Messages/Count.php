<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Count as CountRule;

class Count extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return CountRule::NAME;
    }
}
